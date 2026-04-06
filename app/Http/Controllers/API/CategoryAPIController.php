<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCategoryAPIRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Facades\App\Services\DataAccessValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CategoryAPIController
 * @package App\Http\Controllers\API
 */

class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryAPIController */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }


    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return response()->json($categories);
    }


    public function findByStore($storeId, $type = null)
    {

        $categories = $this->categoryRepository->all();
        return response()->json($categories);

    }



    public function store(CreateCategoryAPIRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->create($input);

        return response()->json($category);
    }


    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }
        return response()->json($category);
    }


    public function update($id, Request $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category = $this->categoryRepository->update($input, $id);

        return response()->json($category);
    }

    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category->delete();

        return $this->sendSuccess('Category deleted successfully');
    }
}
