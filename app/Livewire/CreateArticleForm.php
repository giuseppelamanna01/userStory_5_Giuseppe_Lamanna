<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;

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
            'price' => 'required|numeric|min:0',
            'category' => 'required',
            'temporary_images.*' => 'image|max:1024',
            'images.*' => 'image|max:1024',
        ]);

        $article = Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id()
        ]);

        if (count($this->images) > 0) {
            foreach ($this->images as $image) {
                $article->images()->create(['path' => $image->store('images', 'public')]);
            }
        }

        session()->flash('success', 'Articolo creato correttamente');
        $this->reset('title', 'description', 'price', 'category');
        $this->showSuccess = true;
        $this->cleanForm();
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
        $this->validate([
            'temporary_images' => 'nullable|array',
            'temporary_images.*' => 'image|max:1024',
        ]);

        foreach ($this->temporary_images as $image) {
            $this->images[] = $image;
        }
    }

    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->images))) {
            unset($this->images[$key]);
        }
    }
}