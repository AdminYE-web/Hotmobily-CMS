<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class HeadingContent
{
    public static function defaults(): array
    {
        return ['alignment'=>'center', 'background_color'=>'#f3f3f3', 'text_color'=>'#000000',
            'underline_color'=>'#ff8000', 'show_underline'=>true, 'underline_width'=>3];
    }

    public static function style(array $input): array
    {
        $style = array_replace(self::defaults(), array_intersect_key($input, self::defaults()));
        Validator::make($style, [
            'alignment'=>'required|in:left,center,right',
            'background_color'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'text_color'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'underline_color'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'show_underline'=>'required|boolean', 'underline_width'=>'required|integer|between:1,12',
        ])->validate();
        foreach (['background_color','text_color','underline_color'] as $key) $style[$key] = strtolower($style[$key]);
        $style['show_underline'] = (bool) $style['show_underline'];
        $style['underline_width'] = (int) $style['underline_width'];
        return $style;
    }

    public static function normalize(array $input): array
    {
        Validator::make($input, ['text'=>'nullable|string|max:1000', 'updated_date'=>'nullable|string|max:100', 'heading_style'=>'sometimes|array'])->validate();
        $clean = ['text'=>(string) ($input['text'] ?? '')];
        foreach (['updated_date','background_color'] as $key) if (array_key_exists($key,$input)) $clean[$key] = (string) ($input[$key] ?? '');
        if (array_key_exists('heading_style',$input)) $clean['heading_style'] = self::style($input['heading_style']);
        return $clean;
    }
}
