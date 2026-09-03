<div class="flex-item">
    <label class="part-name">
        <input type="radio" name="paper" onclick="window.setToInput ? setToInput() : (window.calcAcrylic ? calcAcrylic() : null)" value="paper-patternA-1" {{ ($paper ?? '') === 'paper-patternA-1' ? 'checked' : '' }}>
        <img src="/products/acrylic/img/paper-patternA-1.webp" width="154px" alt="Pattern A-1">
    </label>
</div>
<div class="flex-item">
    <label class="part-name">
        <input type="radio" name="paper" onclick="window.setToInput ? setToInput() : (window.calcAcrylic ? calcAcrylic() : null)" value="paper-patternA-2" {{ ($paper ?? '') === 'paper-patternA-2' ? 'checked' : '' }}>
        <img src="/products/acrylic/img/paper-patternA-2.webp" width="154px" alt="Pattern A-2">
    </label>
</div>
@for ($p = 0; $p <= 50; $p++)
<div class="flex-item">
    <label class="part-name">
        <input type="radio" name="paper" onclick="window.setToInput ? setToInput() : (window.calcAcrylic ? calcAcrylic() : null)" value="paper-pattern{{ $p }}" {{ ($paper ?? '') === 'paper-pattern' . $p ? 'checked' : '' }}>
        <img src="/products/acrylic/img/paper-pattern{{ $p }}.webp" width="154px" alt="Pattern {{ $p }}">
    </label>
</div>
@endfor
