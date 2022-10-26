<?php

namespace App\Http\Controllers\backend;

use App\Component\Recursive;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Traits\StorageImageTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use StorageImageTrait;

    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;

    public function __construct(Category $category, Product $product, ProductImage $productImage, Tag $tag, ProductTag $productTag)
    {
        $this->productImage = $productImage;
        $this->product = $product;
        $this->category = $category;
        $this->tag = $tag;
        $this->productTag = $productTag;
    }

    public function index()
    {
        $products = $this->product->paginate(15);
        return view('backend.product.index', compact('products'));
    }
    public function create()
    {
        $htmlOption = $this->getCategory($parentId = '');
        return view('backend.product.create',compact('htmlOption'));
    }
    public function getCategory($parentId)
    {
        $categories = $this->category->all();
        $recursive = new Recursive($categories);
        $htmlOption = $recursive->categoryRecursive($parentId);
        return $htmlOption;
    }
    public function store(ProductRequest $request)
    {
        try{
            DB::beginTransaction();
            $dataProductCreate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage))
            {
                $dataProductCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            $product = $this->product->create($dataProductCreate);
            if($request->hasFile('image_path'))
            {
                foreach ($request->image_path as $fileItem)
                {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                    $product->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name'],
                    ]);

                }
            }
            $tagIds = [];
            if(!empty($request->tags))
            {
                foreach ($request->tags as $tagItem)
                {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->attach($tagIds);
            DB::commit();
            return redirect()->route('product.index');
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error('message: ' .$exception->getMessage() . 'line :' .$exception->getLine());
        }

//        $file = $request->feature_image_path;
//        $fileName = $request->feature_image_path->getClientOriginalName();
//        $path = $request->file('feature_image_path')->storeAs('public/product',$fileName);
//        $data = [
//            'file_name' => $fileName,
//            'file_path' => Storage::url($path)
//        ];
    }
    public function edit($id)
    {
        $product = $this->product->find($id);
        $htmlOption = $this->getCategory($product->category_id);
        return view('backend.product.edit',compact('htmlOption','product'));
    }
    public function update(Request $request,$id)
    {
        try{
            DB::beginTransaction();
            $dataProductUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if(!empty($dataUploadFeatureImage))
            {
                $dataProductUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataProductUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $product = $this->product->find($id);
            if($request->hasFile('image_path'))
            {
                $this->productImage->where('product_id',$id)->delete();
                foreach ($request->image_path as $fileItem)
                {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem,'product');
                    $product->images()->update([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name'],
                    ]);

                }
            }
            $tagIds = [];

            if(!empty($request->tags))
            {
                $this->productImage->where('product_id',$id)->delete();
                foreach ($request->tags as $tagItem)
                {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tagItem]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->sync($tagIds);
            DB::commit();
            return redirect()->route('product.index');
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error('message: ' .$exception->getMessage() . 'line :' .$exception->getLine());
        }
    }
    public function delete($id)
    {
//        try {
//            $this->product->find($id)->delete();
//            return response()->json([
//                'code' => 200,
//                'message' => 'success'
//            ], 200);
//        }
//        catch (\Exception $exception)
//        {
//            Log::error('Messenger: ' . $exception->getMessage() . '--line :' .$exception->getLine());
//            return response()->json([
//                'code' => 500,
//                'message' => 'fail'
//            ],500);
//        }
        $product = $this->product->find($id);
        $product->delete();
        Toastr::success('Message', 'Delete Success');
        return redirect()->route('product.index');
    }
}

