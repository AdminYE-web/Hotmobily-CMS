<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class ProductAnatomyContent
{
    public static function defaults(): array
    {
        return ['title'=>'','left_image'=>'','right_image'=>'','left_mobile_image'=>'','right_mobile_image'=>'',
            'left_alt'=>'','right_alt'=>'','image_width'=>55,'line_color'=>'#666666','point_color'=>'#ff8000','pulse'=>true,
            'details_enabled'=>false,'detail_left_image'=>'','detail_right_image'=>'','detail_title'=>'','detail_description'=>'','items'=>[]];
    }

    public static function example(): array
    {
        $item=fn($id,$side,$title,$description,$x,$y,$url='')=>compact('id','side','title','description','x','y','url')+['label_y'=>$y];
        return array_replace(self::defaults(),[
            'left_image'=>'/images/product-anatomy-example/210-L.webp','right_image'=>'/images/product-anatomy-example/210-R.webp',
            'left_mobile_image'=>'/images/product-anatomy-example/285-L.webp','right_mobile_image'=>'/images/product-anatomy-example/285-R.webp',
            'left_alt'=>'ラバーキーホルダー表面','right_alt'=>'ラバーキーホルダー裏面','details_enabled'=>true,
            'detail_left_image'=>'/images/product-anatomy-example/base_3mm.webp','detail_right_image'=>'/images/product-anatomy-example/base_5mm.webp',
            'detail_title'=>'ベース厚','detail_description'=>'<p>3mmの通常品と、より重厚感のある5mmが選択可。</p>',
            'items'=>[
                $item('attachment','left','豊富なアタッチメント','<p>金色ナスカンやハート型も選択可。ゴム松葉やカラーボールチェーンは、<a href="/products/rubberstrap/">ラバーストラップ</a>に掲載。</p>',8,16.7,'#part_keyholder'),
                $item('mold','left','金型に注型し製品を作成','<p>ゴムの液体を金型に注型し製作。印刷物ではありません。スリット線で色をわけます。</p>',65,50),
                $item('base','left','ベース層','<p>製品の土台となる層です。ほとんどの場合黒色。指定色での製作も可能。</p>',55,83.3),
                $item('print','right','裏面白色印刷','<p>シルク印刷より綺麗で剥がれにくいUV印刷を採用。白色以外も印刷可能です。</p>',11,50),
                $item('back','right','裏面ベース層','<p>裏面はベース層の1色です。</p>',15,70),
            ],
        ]);
    }

    public static function normalize(array $input): array
    {
        $data=array_replace(self::defaults(),$input);
        $url=static function ($attribute,$value,$fail): void {
            if(!is_string($value)||preg_match('/[\x00-\x20\\\\]/',$value)){ $fail('Use a local path or HTTP/HTTPS URL.'); return; }
            if(str_starts_with($value,'/')&&!str_starts_with($value,'//'))return;
            if(str_ends_with($attribute,'.url')&&preg_match('/^#[A-Za-z][A-Za-z0-9_-]*$/',$value))return;
            if(filter_var($value,FILTER_VALIDATE_URL)&&in_array(strtolower(parse_url($value,PHP_URL_SCHEME)??''),['http','https'],true))return;
            $fail('Use a local path or HTTP/HTTPS URL.');
        };
        $rules=['title'=>'nullable|string|max:255','left_alt'=>'nullable|string|max:500','right_alt'=>'nullable|string|max:500',
            'image_width'=>'required|integer|between:35,75','line_color'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'point_color'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],'pulse'=>'required|boolean','details_enabled'=>'required|boolean',
            'detail_title'=>'nullable|string|max:255','detail_description'=>'nullable|string|max:50000',
            'items'=>'present|array|max:20','items.*'=>'required|array','items.*.id'=>['required','string','max:80','regex:/^[A-Za-z0-9_-]+$/','distinct'],
            'items.*.side'=>'required|in:left,right','items.*.title'=>'nullable|string|max:255','items.*.description'=>'nullable|string|max:50000',
            'items.*.url'=>['nullable','string','max:2000',$url],
            'items.*.x'=>'required|numeric|between:0,100','items.*.y'=>'required|numeric|between:0,100','items.*.label_x'=>'sometimes|numeric|between:-100,100','items.*.label_y'=>'required|numeric|between:0,100'];
        foreach(['left_image','right_image','left_mobile_image','right_mobile_image','detail_left_image','detail_right_image'] as $field)$rules[$field]=['nullable','string','max:2000',$url];
        Validator::make($data,$rules)->validate();
        $clean=array_intersect_key($data,self::defaults());
        foreach(['title','left_image','right_image','left_mobile_image','right_mobile_image','left_alt','right_alt','detail_left_image','detail_right_image','detail_title'] as $key)$clean[$key]=trim((string)($data[$key]??''));
        $clean['image_width']=(int)$data['image_width'];$clean['pulse']=(bool)$data['pulse'];$clean['details_enabled']=(bool)$data['details_enabled'];
        $sanitizer=new RichTextSanitizer;$clean['detail_description']=$sanitizer->sanitize($data['detail_description']??'')??'';
        $clean['items']=array_map(fn($item)=>['id'=>$item['id'],'side'=>$item['side'],'title'=>(string)($item['title']??''),
            'description'=>$sanitizer->sanitize($item['description']??'')??'','url'=>trim((string)($item['url']??'')),
            'x'=>round((float)$item['x'],2),'y'=>round((float)$item['y'],2),'label_x'=>round((float)($item['label_x']??0),2),'label_y'=>round((float)$item['label_y'],2)],array_values($data['items']));
        return $clean;
    }
}
