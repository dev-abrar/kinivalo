<tbody>
    <tr>
        <td><input type="text" wire:model='color_name.0' placeholder="কালার নাম" name="color_name[]" class="form-control">
        </td>
        <td>
            <input type="file" id="photo.0" wire:model='color_photo.0' name="color_photo[]" class="form-control">

            @if ($color_photo)
                <img width="50" src="{{ $color_photo[0]->temporaryUrl() }}" class="img d-block mt-2" alt="">
            @endif
        </td>
        <td><input type="number" wire:model='color_price.0' placeholder="দাম " name="color_price[]"
                class="form-control">
        </td>
        <td><input type="number" wire:model='color_quantity.0' placeholder="পরিমান" name="color_quantity[]"
                class="form-control"></td>
        <td>
            <button type="button" class="btn btn-success" wire:click.prevent='add({{ $i }})'>
                <i class="fa fa-plus"></i>
            </button>
        </td>
    </tr>

    @foreach ($inputs as $key => $value)
        <tr>
            <td><input type="text" wire:model='color_name.{{ $value }}' placeholder="কালার নাম"
                    name="color_name[]" class="form-control">
            </td>
            <td>
                <input type="file" wire:model='color_photo.{{ $value }}' name="color_photo[]"
                    class="form-control">

                    @if (isset($color_photo[$value]))
                    <img width="50" src="{{ $color_photo[$value]->temporaryUrl() }}" class="img d-block mt-2" alt="">
                @endif
            </td>
            <td><input type="number" wire:model='color_price.{{ $value }}' placeholder="দাম"
                    name="color_price[]" class="form-control">
            </td>
            <td><input type="number" wire:model='color_quantity.{{ $value }}' placeholder="পরিমান"
                    name="color_quantity[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger" wire:click.prevent='remove({{ $key }})'>
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>
    @endforeach
</tbody>
