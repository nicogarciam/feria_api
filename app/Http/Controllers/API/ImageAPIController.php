<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Benefit;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Product;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Response;


class ImageAPIController extends AppBaseController
{

    public function __construct()
    {
    }


    public function delete($id)
    {

        $resp = DB::table('images')->where('id','=', $id)->delete();

        if (!$resp) {
            return $this->sendError('Image not found');
        }

        return $this->sendSuccess('Image deleted successfully');

    }

    public function uploadProductImage(Request $request, $productId)
    {

        try {
            $product = Product::findOrFail($productId);
            $images = $request->input('images');
            $savedImages = [];
            Image::where('product_id', $productId)->delete();

            foreach ($images as $image) {
                // Decodificar la imagen base64
                if (preg_match('/^data:image\/(\w+);base64,/', $image['src'])) {
                    $data = substr($image['src'], strpos($image['src'], ',') + 1);
                    $data = base64_decode($data);

                    // Crear nombre único para la imagen
                    $fileName = 'product_' . $productId . '_' . uniqid() . '.png';

                    // Guardar la imagen en el storage
                    Storage::disk('public')->put('products/' . $fileName, $data);

                    // Crear registro en la base de datos
                    $productImage = Image::create([
                        'product_id' => $productId,
                        'src' => 'storage/products/' . $fileName,
                        'title' => $fileName,
                    ]);

                    $savedImages[] = $productImage;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Imágenes guardadas correctamente',
                'data' => $savedImages
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar las imágenes: ' . $e->getMessage()
            ], 500);
        }
    }


    public function deleteProductImage($productId)
    {
        try {
            DB::beginTransaction();

            // Obtener todas las imágenes asociadas al producto
            $images = Image::where('product_id', $productId)->get();

            if ($images->isEmpty()) {
                return $this->sendError('No se encontraron imágenes para este producto');
            }

            foreach ($images as $image) {
                // Obtener la ruta del archivo
                $filePath = str_replace('storage/', '', $image->src);

                // Eliminar el archivo físico
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                // Eliminar el registro de la base de datos
                $image->delete();
            }

            DB::commit();
            return $this->sendSuccess('Imágenes eliminadas correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error al eliminar las imágenes: ' . $e->getMessage());
        }


    }

    public function uploadImage(Request $request)
    {

        $input = $request->all();

        if ($request->hasFile('image')) {
            $date = time();
            $image = $request->file('image');
            $filename = $date . '_' . $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();

            $filename = $this->sanitize($filename);

            $path = $request->file('image')->storePubliclyAs(
                'images/uploads',
                $filename,
                'local');
//            $account->image_url = url($path);

//            $account = $this->accountRepository->update($account->toArray(), $account->id);

            $newImage = array([
                'title' => $filename,
                'src' => url($path),
                'product_id' => $input['product_id'],
            ]);

            $resp['src'] = url($path);
            $resp['id'] = DB::table('images')->insertGetId($newImage);

            return response()->json($resp);
        } else {
            return response()->json(404);
        }
    }

    public function suggestPrice($id, AIService $aiService)
    {
        $image = Image::find($id);

        if (!$image) {
            return $this->sendError('Image not found.', 404);
        }

        $imagePath = $image->src; // As used in extractFeatures method

        try {
            // Step 1: Extract features
            // AIService::extractFeatures returns an array directly (not a Response object)
            $features = $aiService->extractFeatures($imagePath);

            // Optional: Check if features are empty or indicate an error if AIService was designed that way
            if (empty($features)) {
                // This check depends on how AIService::extractFeatures signals error/no features
                return $this->sendError('Could not extract features for the image.', 422);
            }

            // Step 2: Get suggested price based on features
            // AIService::getSuggestedPrice returns an array
            $suggestedPrice = $aiService->getSuggestedPrice($features);

            if (empty($suggestedPrice)) {
                 return $this->sendError('Could not retrieve price suggestion.', 500);
            }

            return $this->sendResponse($suggestedPrice, 'Price suggestion retrieved successfully.');

        } catch (\Exception $e) {
            // Log::error("Price suggestion failed for image ID {$id}: " . $e->getMessage());
            // Differentiate between feature extraction failure and price suggestion failure if possible
            return $this->sendError('An error occurred while processing the image for price suggestion.', 500);
        }
    }

    public function extractFeatures($id, AIService $aiService)
    {
        $image = Image::find($id);

        if (!$image) {
            return $this->sendError('Image not found.', 404);
        }

        // The 'src' attribute should hold the path like 'storage/images/uploads/filename.jpg'
        // For the AIService, we might need a full path or a path relative to the storage/app directory.
        // Assuming AIService can handle the path as stored in 'src' or can derive it.
        // If AIService needs an absolute path, this might need adjustment: e.g., storage_path('app/public/' . str_replace('storage/', '', $image->src))
        $imagePath = $image->src;

        try {
            $features = $aiService->extractFeatures($imagePath);
            return $this->sendResponse($features, 'Image features extracted successfully.');
        } catch (\Exception $e) {
            // Log::error("Feature extraction failed for image ID {$id}: " . $e->getMessage());
            return $this->sendError('Failed to extract image features.', 500);
        }
    }

    public function uploadImageGeneral(Request $request)
    {
        if (!$request->hasFile('image')) {
            return $this->sendError('No image file uploaded.', 400);
        }

        $imageFile = $request->file('image');

        // Basic validation for image type (can be expanded)
        $allowedMimes = ['jpeg', 'png', 'jpg', 'gif', 'svg'];
        if (!in_array($imageFile->getClientOriginalExtension(), $allowedMimes)) {
            return $this->sendError('Invalid image type.', 415);
        }

        try {
            $date = time();
            $originalName = $imageFile->getClientOriginalName();
            $sanitizedOriginalName = $this->sanitize($originalName, true); // Sanitize for filename
            $filename = $date . '_' . $sanitizedOriginalName;

            // Store in storage/app/public/images/uploads
            $path = $imageFile->storeAs('public/images/uploads', $filename);

            if (!$path) {
                return $this->sendError('Failed to save image.', 500);
            }

            // Create database entry
            $imageId = DB::table('images')->insertGetId([
                'src' => 'storage/images/uploads/' . $filename, // Path accessible via symlink
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!$imageId) {
                // Attempt to delete the stored file if DB insertion fails
                Storage::delete($path);
                return $this->sendError('Failed to create image record in database.', 500);
            }

            return $this->sendResponse(['id' => $imageId], 'Image uploaded successfully.');

        } catch (\Exception $e) {
            // Log the exception details (optional but recommended)
            // Log::error("Image upload failed: " . $e->getMessage());
            return $this->sendError('An unexpected error occurred during image upload.', 500);
        }
    }

    public function set_primary(Request $request){

        $img = $request->all();
        Image::where('benefit_id', $img['benefit_id'])
            ->where('store_id', $img['store_id'])
            ->where('activity_id', $img['activity_id'])
            ->where('event_id', $img['event_id'])
            ->update(['primary' => 0]);

        Image::where('id', $img['id'])
            ->update(['primary' => 1]);

        if ($img['benefit_id'] != null){

            Benefit::where('id', $img['benefit_id'])
                ->update(['image_url' => $img['src']]);
            $images = Image::where('benefit_id',$img['benefit_id'])->get();
            return response()->json($images);

        }


        if ($img['store_id'] != null){
            Entity::where('id', $img['entity_id'])
                ->update(['image_url' => $img['src']]);
            $images = Image::where('en',$img['store_id'])->get();
            return response()->json($images);
        }
//        if ($img['activity_id'] != null){
//            Activity::where('id', $img['activity_id'])
//                ->update(['image_url' => $img['src']]);
//        }
//        if ($img['event_id'] != null){
//            Event::where('id', $img['event_id'])
//                ->update(['image_url' => $img['src']]);
//        }




    }


    function sanitize($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-' . ($is_filename ? '~_\.' : '') . ']+/u', '-', $string);

        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }

}
