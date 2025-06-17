<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Benefit;
use App\Models\Entity;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $resp['src'] = url($path);
            $resp['id'] = DB::table('images')->insertGetId([
                'src' => url($path)
            ]);

            return response()->json($resp);
        } else {
            return response()->json(404);
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
