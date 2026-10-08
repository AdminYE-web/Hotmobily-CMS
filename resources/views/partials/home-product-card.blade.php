<table width="100%" cellspacing="0" class="tbl_index">
    <tr>
        <td>
            <a href="{{ url('/products/' . trim($homeProductCard->product->slug, '/')) }}">
                <div class="banner_box_flex">
                    <div class="img_box">
                        <img src="{{ Storage::disk('public')->url($homeProductCard->image_path) }}" width="157" height="120" alt="{{ $homeProductCard->name }}">
                    </div>
                    <div class="home-product-description">
                        <span class="topic">{{ $homeProductCard->name }}</span>
                        <div class="detail">{!! $homeProductCard->description_html !!}</div>
                    </div>
                    <div class="text-box home-product-features">{!! $homeProductCard->features_html !!}</div>
                </div>
            </a>
        </td>
    </tr>
</table>
