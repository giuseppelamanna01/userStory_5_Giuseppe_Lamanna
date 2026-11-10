<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            @if($showSuccess)
                <div class="alert alert-success text-center">
                    Articolo creato correttamente
                </div>
            @endif

            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label>Titolo</label>
                    <input type="text" wire:model.blur="title" class="form-control">
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Descrizione</label>
                    <textarea wire:model.blur="description" class="form-control"></textarea>
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Prezzo</label>
                    <input type="number" step="0.01" wire:model.blur="price" class="form-control">
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Categoria</label>
                    <select wire:model.blur="category" class="form-control">
                        <option value="">Seleziona una categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- inserimento immagini --}}
                    <div class="mb-3">
                        <input type="file" wire:model.live="temporary_images" multiple
                            class="form-control shadow @error('temporary_images.*') is-invalid @enderror" placeholder="Img"/>
                        @error('temporary_images.*')
                            <p class="fst-italic text-danger">{{ $message }}</p>
                        @enderror
                        @error('temporary_images')
                            <p class="fst-italic text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (!empty($images))
                        <div class="row">
                            <div class="col-12">

                                ...code
                                <p>Photo preview:</p>
                                <div class="row border border-4 border-success routned shadow py-4">
                                    @foreach ($images as $key => $image)
                                        <div class="col d-flex flex-column align-items-center my-3">
                                            <div
                                                class="img-preview mx-auto shadow rounded"
                                                style="background-image: url({{ $image->temporaryUrl() }});">
                                            </div>
                                            <button type="button" class="btn mt-1 btn-danger "
                                                wire:click="removeImage({{ $key }})">X</button>
                                        </div>
                                    @endforeach
                                </div>  
                            </div>
                        </div>
                    @endif

                <button type="submit" class="btn btn-dark">Crea</button>
            </form>

        </div>
    </div>
</div>