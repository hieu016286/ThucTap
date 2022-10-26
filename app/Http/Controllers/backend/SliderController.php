<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SliderRequest;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Brian2694\Toastr\Facades\Toastr;
use http\Client\Request;
use function view;

class SliderController extends Controller
{
    use StorageImageTrait;
    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider= $slider;
    }

    public function index()
    {
        $sliders = $this->slider->paginate(15);
        return view('backend.slider.index',compact('sliders'));
    }
    public function create()
    {
        return view('backend.slider.create');
    }
    public function store(SliderRequest $request)
    {
        $dataInsert = [
            'name' => $request->name,
            'description' => $request->description
        ];
        $dataImageSlider = $this->storageTraitUpload($request,'image_path','slider');
        if(!empty($dataImageSlider))
        {
            $dataInsert['image_name'] = $dataImageSlider['file_name'];
            $dataInsert['image_path'] = $dataImageSlider['file_path'];
        }
        $this->slider->create($dataInsert);
        return redirect()->route('slider.index');
    }
    public function edit($id)
    {
        $slider = $this->slider->find($id);
        return view('backend.slider.edit',compact('slider'));
    }
    public function update(SliderRequest $request, $id)
    {
        $dataUpdate = [
            'name' => $request->name,
            'description' => $request->description
        ];
        $dataImageSlider = $this->storageTraitUpload($request,'image_path','slider');
        if(!empty($dataImageSlider))
        {
            $dataUpdate['image_name'] = $dataImageSlider['file_name'];
            $dataUpdate['image_path'] = $dataImageSlider['file_path'];
        }
        $this->slider->update($dataUpdate);
        return redirect()->route('slider.index');
    }
    public function delete($id)
    {
        $slider = $this->slider->find($id);
        $slider->delete();
        Toastr::success('Message', 'Delete Success');
        return redirect()->route('slider.index');
    }
}
