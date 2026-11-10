<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;


class CreateArticleForm extends Component
{
    use WithFileUploads;
    public $title = '';
    public $description = '';
    public $price = '';
    public $category = '';
    public $showSuccess = false;
    public $images = [];
    public $temporary_images;

    public function store()
    {
        $this->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'category' => 'required|exists:categories,id',
        ]);

        Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id()
        ]);

        if (count($this->images) > 0) {
        foreach ($this->images as $image) {
            $this->article->images()->create(['path' => $image->store('images', 'public')]);
        }
    }

        session()->flash('success', 'Articolo creato correttamente');
        $this->cleanForm();


        $this->reset(['title', 'description', 'price', 'category']);
        $this->showSuccess = true;
    }
    protected function cleanForm()
    {
        $this->title = '';
        $this->description = '';
        $this->category = '';
        $this->price = '';
        $this->images = [];
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.create-article-form', compact('categories'));
    }

    public function updatedTemporaryImages()
    {
        if ($this->validate([
            'temporary_images.*' => 'image|max:1024',
            'temporary_images'=>'max:6'
        ])) {
            foreach ($this->temporary_images as $image) {
                $this->images[] = $image;
            }
        }
    }

    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->images))) {
            unset($this->images[$key]);
        }
    }
}