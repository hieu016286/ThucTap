<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Component\Recursive;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->latest()->paginate(4);
        return view('backend.category.index', compact('categories'));
    }

    public function getCategory($parentId)
    {
        $categories = $this->category->all();
        $recursive = new Recursive($categories);
        return $recursive->categoryRecursive($parentId);
    }

    public function create()
    {
        $htmlOption = $this->getCategory('');
        return view('backend.category.create', compact('htmlOption'));
    }

    public function store(Request $request)
    {
        $this->category->create([
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'parent_id' => $request['parent_name']
        ]);
        Toastr::success('Message', 'Create Success');
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $category = $this->category->find($id);
        $htmlOption = $this->getCategory($category->parent_id);
        return view('backend.category.edit', compact('category', 'htmlOption'));
    }

    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);
        $category->update([
            'name' => $request['name'],
            'slug' => Str::slug($request['name']),
            'parent_id' => $request['parent_name']
        ]);
        Toastr::success('Message', 'Update Success');
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        $category = $this->category->find($id);
        $category->delete();
        $this->deleteRecursive($category);
        Toastr::success('Message', 'Delete Success');
        return redirect()->route('category.index');
    }

    public function deleteRecursive($category)
    {
        if(count($category->children)) {
            foreach ($category->children as $child) {
                $child->delete();
                $this->deleteRecursive($child);
            }
        }
    }
}
