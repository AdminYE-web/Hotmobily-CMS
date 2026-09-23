@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="デザインテンプレート,ダウンロード">
    <meta name="description" content="オリジナルグッズを製作する際のデザインテンプレートがダウンロードできます。ラバーストラップ、アクキーなど。">
    <meta name="robots" content="index,follow">
    <title>デザインテンプレートのダウンロード HOTMOBILYオリジナルグッズ</title>

    @include('partials.legacy-head-products')

    <style type="text/css">
        .template_tbl {
        			width: 100%;
        			border-spacing: unset;
        			margin: 10px 0;
        		}
        
        		.template_tbl .left {
        			width: 25%;
        			background: #f58904;
        			color: white;
        			text-align: center;
        			line-height: 3;
        			border: 1px solid #f58904;
        		}
        
        		.template_tbl .right {
        			border: 1px solid lightgray;
        			border-left: unset;
        		}
        
        		#prd_name {
        			padding: 5px;
        			margin-left: 10px;
        			font-size: 15px;
        		}
        
        		#result table {
        			width: 100%;
        			display: none;
        			border-spacing: unset;
        			border-collapse: collapse;
        		}

                #result .template-product-result {
                    display: none;
                }

                #result .template-product-result table {
                    display: table;
                    margin-bottom: 10px;
                }
        
        		#result table td.left {
        			width: 40%;
        			line-height: 2.5;
        			background: #f0f0f0;
        			padding-left: 10px !important;
        			border: 1px solid #000;
        		}
        
        		#result table td.right {
        			width: 60%;
        			line-height: 2.5;
        			padding-left: 10px !important;
        			border: 1px solid #000;
        			border-left: unset;
        			border-bottom: unset;
        		}
        
        		#result table td.right:last-child {
        			border-bottom: 1px solid #000;
        		}
        
        		#result table td.right a:hover {
        			background: white;
        			color: #000;
        			transition-duration: 0.2s;
        		}
        
        		#result table td.right a {
        			text-decoration: none;
        			color: white;
        			background: #555;
        			padding: 5px 10px;
        			border-radius: 5px;
        			border: 1px solid #555;
        			transition-duration: 0.2s;
        			margin-right: 10px;
        		}
        
        		.csp {
        			margin-top: 10px;
        		}
        
        		@media (max-width: 576px) {
        			.template_tbl .left {
        				width: 30%;
        			}
        
        			#prd_name {
        				font-size: 12px;
        			}
        
        			#result table td.right a {
        				padding: 5px;
        				margin-right: 0px;
        				display: -webkit-box;
        				margin-bottom: 5px;
        				margin-top: 5px;
        			}
        		}
        
        		@media (max-width:340px) {
        			#result table td.right a {
        				font-size: 10px;
        			}
        
        			#prd_name {
        				font-size: 10px;
        			}
        		}
    </style>
@endsection

@section('content')
    @php($usesManagedTemplates = isset($templateProducts) && $templateProducts->isNotEmpty())

    <h1 itemprop="name">デザインテンプレートダウンロード｜HOTMOBILYオリジナルグッズ</h1>

    <table class="template_tbl">
        <tr>
            <td class="left">製品名</td>
            <td class="right">
                <select id="prd_name">
							@if ($usesManagedTemplates)
								<option value="">製品を選択してください</option>
								@foreach ($templateProducts as $templateProduct)
									<option value="{{ $templateProduct->id }}" data-product-name="{{ $templateProduct->name }}">{{ $templateProduct->name }}</option>
								@endforeach
							@else
                							<optgroup style="display: none;"></optgroup>
                							<option value="">製品を選択してください</option>
                							<option value="ラバーストラップ">ラバーストラップ</option>
                							<option value="ラバーキーホルダー">ラバーキーホルダー</option>
                
                                            <option value="印刷ラバーストラップ">印刷ラバーストラップ</option>
                
                							<option value="ラバーコースター">ラバーコースター</option>
                
                                            <option value="印刷ラバーコースター">印刷ラバーコースター</option>
                
                							<option value="ラバーイヤホンホルダー">ラバーイヤホンホルダー</option>
                							<option value="ラバーキーカバー">ラバーキーカバー</option>
                							<option value="ラバーゴルフターゲットカップ">ラバーゴルフターゲットカップ</option>
                							<option value="ラバータグ">ラバータグ</option>
                							<option value="ラバーフォトフレーム">ラバーフォトフレーム</option>
                							<option value="ラバーケーブルバンド">ラバーケーブルバンド</option>
                							<option value="アクリルキーホルダー">アクリルキーホルダー</option>
                							<option value="2連アクリルキーホルダー">2連アクリルキーホルダー</option>
                							<option value="ブリスターパック風アクリルキーホルダー">ブリスターパック風アクリルキーホルダー</option>
                
                							<option value="シャカシャカアクリルキーホルダー">シャカシャカアクリルキーホルダー</option>
                							<option value="アクリル詰め放題">アクリル詰め放題</option>
                
                                            <option value="再生材料アクリルキーホルダー">再生材料アクリルキーホルダー</option>
                                            <option value="レインボーアクリルキーホルダー">レインボーアクリルキーホルダー</option>
                                            <option value="オーロラアクリルキーホルダー">オーロラアクリルキーホルダー</option>
                
                                            <option value="お守りアクリルキーホルダー">お守りアクリルキーホルダー</option>
                
                							<option value="アクリルスタンド">アクリルスタンド</option>
                
                							<option value="ジオラマアクリルスタンド">ジオラマアクリルスタンド</option>
                							<option value="モニターアクリルスタンド">モニターアクリルスタンド</option>
                
                                            <option value="レインボーアクリルスタンド">レインボーアクリルスタンド</option>
                                            <option value="オーロラアクリルスタンド">オーロラアクリルスタンド</option>
                                            <option value="アクリルパネル（アクリルボード）">アクリルパネル（アクリルボード）</option>
                
                							<option value="アクリルスマホスタンド">アクリルスマホスタンド</option>
                							<option value="めじるしチャーム（アクリルアンブレラマーカー）">めじるしチャーム（アクリルアンブレラマーカー）</option>
                							<option value="アクリルクリップ（アクリルバッジ）">アクリルクリップ（アクリルバッジ）</option>
                							<option value="アクリルコースター">アクリルコースター</option>
                							<option value="アクリルヘアバンド">アクリルヘアバンド</option>
                							<option value="アクリルスマホグリップトック（アクリルグリップホルダー）">アクリルスマホグリップトック（アクリルグリップホルダー）</option>
                							<option value="PVCクリアマルチケース">PVCクリアマルチケース</option>
                
                							<option value="クッションポーチ">クッションポーチ</option>
                                            <option value="お守り">お守り</option>
                                            <option value="タペストリー（A2・B2・B1）">タペストリー（A2・B2・B1）</option>
                                            <option value="デスクマット">デスクマット</option>
                                            <option value="タンブラー">タンブラー</option>
                                            <option value="ボトルオープナー">ボトルオープナー</option>
                
                							<option value="反射リストバンド">反射リストバンド</option>
                							<option value="マイクロファイバーメガネクロス">マイクロファイバーメガネクロス</option>
                							<option value="マイクロファイバーポーチ">マイクロファイバーポーチ</option>
                							<option value="リサイクル原糸マイクロファイバークロス">リサイクル原糸マイクロファイバークロス</option>
                							<option value="オリジナルメガネクロス">オリジナルメガネクロス（裏面タオル地）</option>
                							<option value="オリジナルメガネケース">オリジナルメガネケース</option>
                							<option value="スタビーホルダー">スタビーホルダー</option>
                							<option value="オリジナルビーチサンダル">オリジナルビーチサンダル</option>
                							<option value="携帯灰皿ノベルティ製作">携帯灰皿ノベルティ製作</option>
                							<option value="オリジナル名入れカラビナ">オリジナル名入れカラビナ</option>
                
                							<option value="オリジナル保冷剤">オリジナル保冷剤</option>
                							<option value="スマホクリーナー（ラバストタイプ）">スマホクリーナー（ラバストタイプ）</option>
                							<option value="ラバースマートフォンスタンド">ラバースマートフォンスタンド</option>
                							<option value="リフレクターシール">リフレクターシール</option>
                							<option value="フローティングキーホルダー">フローティングキーホルダー</option>
                							<option value="キッチンスポンジ">キッチンスポンジ</option>
                							<option value="フライトタグ">フライトタグ</option>
                
                							<option value="ワッペン・パッチ">ワッペン・パッチ</option>
                							<option value="刺繍キーホルダー">刺繍キーホルダー</option>
                							<option value="刺繍バッジ">刺繍バッジ</option>
                							<option value="刺繍コースター">刺繍コースター</option>
                
                							<option value="マイクロファイバーマウスパッド">マイクロファイバーマウスパッド</option>
                							<option value="マイクロファイバークロススウェード生地">マイクロファイバークロス スウェード生地</option>
                							<option value="マイクロファイバークロス100％リサイクルポリエステル">マイクロファイバークロス 100％リサイクルポリエステル</option>
                							<option value="エコカイロ">エコカイロ</option>
                							<option value="スマホ手袋">スマホ手袋</option>
                							<option value="コンパクトジョグボトル">コンパクトジョグボトル</option>
                							<option value="防水ケース">防水ケース</option>
                							<option value="台紙">台紙</option>
							@endif
                						</select>
            </td>
        </tr>
    </table>

    <div id="result">
				@if ($usesManagedTemplates)
					@foreach ($templateProducts as $templateProduct)
						<div class="template-product-result" data-product-id="{{ $templateProduct->id }}">
							@foreach ($templateProduct->blocks as $block)
								<h3>{{ $block->heading }}</h3>
								<table>
									@foreach ($block->rows as $templateRow)
										<tr>
											<td class="left">{{ $templateRow->size_template }}</td>
											<td class="right">
												@foreach ($templateRow->downloads as $download)
													<a href="{{ $download->file_path }}" download>{{ $download->button_label }}</a>
												@endforeach
											</td>
										</tr>
									@endforeach
								</table>
							@endforeach
						</div>
					@endforeach
				@else
    				<h3></h3>
    				<table class="ラバーストラップ">
    					<tr>
    						<td class="left">80mmx80mm</td>
    						<td class="right">
    							<a href="/products/rubberstrap/download/template-Rubberstrap_final_20260119.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーキーホルダー">
    					<tr>
    						<td class="left">80mmx80mm</td>
    						<td class="right">
    							<a href="/products/rubberkeyholder/download/template-Key Holder_20260119.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="印刷ラバーストラップ">
    					<tr>
    						<td class="left">60mmx60mm</td>
    						<td class="right">
    							<a href="/template/sample/印刷ラバーストラップ・キーホルダーテンプレート.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="印刷ラバーコースター">
    					<tr>
    						<td class="left">90mmx90mm</td>
    						<td class="right">
    							<a href="/products/printedrubbercoaster/download/printedrubbercoaster-template.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="2連アクリルキーホルダー">
    					<tr>
    						<td class="left">各種サイズ（50×50mm／75×75mm／100×100mm）</td>
    						<td class="right">
    							<a href="/products/acrylic/template/template_renketsu_acrylic_ol.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="ブリスターパック風アクリルキーホルダー">
    					<tr>
    						<td class="left">各種サイズ</td>
    						<td class="right">
    							<a href="/products/acrylic/template/blisterpack-acrylic-template20266030.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    
    				<table class="ラバーコースター">
    					<tr>
    						<td class="left">90mmx90mm</td>
    						<td class="right">
    							<a href="/products/rubbercoaster/download/download.php?fname=template-coaster-20250604.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーイヤホンホルダー">
    					<tr>
    						<td class="left">70mmx70mm</td>
    						<td class="right">
    							<a href="/products/cableholder/download/download.php?fname=template-ear phone-final_20260704.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーキーカバー">
    					<tr>
    						<td class="left">70mmx70mm</td>
    						<td class="right">
    							<a href="/products/keycover/download/download.php?fname=template-keycover-final.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーゴルフターゲットカップ">
    					<tr>
    						<td class="left">110mmx110mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-pvc targetcup.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバータグ">
    					<tr>
    						<td class="left">70mmx70mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-Rubbertag.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーフォトフレーム">
    					<tr>
    						<td class="left">150mmx250mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-RubberPhotoFrame.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="ラバーケーブルバンド">
    					<tr>
    						<td class="left">縦90mmX横90mm以内</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-cableband.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    				<table class="アクリルキーホルダー">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				
    				<table class="シャカシャカアクリルキーホルダー">
    					<tr>
    						<td class="left">70mm×70mm</td>
    						<td class="right">
    							<a href="/products/acrylic/template/シャカシャカアクリルキーホルダーテンプレート20260603.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="PVCクリアマルチケース">
    					<tr>
    						<td class="left">60×110mm</td>
    						<td class="right">
    							<a href="/products/pvc-clear-multi-case/template/clearmulticase_template_ol.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリル詰め放題">
    					<tr>
    						<td class="left">148mm × 210mm</td>
    						<td class="right">
    							<a href="/products/acrylic/download/アクリル詰め放題.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="再生材料アクリルキーホルダー">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="レインボーアクリルキーホルダー">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="オーロラアクリルキーホルダー">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="お守りアクリルキーホルダー">
                        <tr>
                            <td class="left">70mmx42mm／75mmx50mm</td>
                            <td class="right">
                                <a href="/products/acrylic/template/template-acrylic_omamori.zip">テンプレートダウンロード</a>
                            </td>
                        </tr>
                    </table>
    
    				<table class="アクリルキーホルダー">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_50mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_75mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_100mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルスタンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_stand_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_stand_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_stand_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="ジオラマアクリルスタンド">
    					<tr>
    						<td class="left">各種サイズ</td>
    						<td class="right">
    							<a href="/products/acrylic/template/diorama-acrylicstand-template20260630.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="モニターアクリルスタンド">
    					<tr>
    						<td class="left">各種サイズ</td>
    						<td class="right">
    							<a href="/products/acrylic/template/monitor_acrylicstand_template_cmyk_2306.zip">テンプレートダウンロード</a>
    						</td>
    					</tr>
    				</table>
    
    
                    <table class="レインボーアクリルスタンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
                    
                    <table class="オーロラアクリルスタンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/acrylic-aurora/template/template-aurora_acrylic_stand_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
                    <table class="アクリルパネル（アクリルボード）">
                        <tr>
                            <td class="left">横向き／縦向き</td>
                            <td class="right">
                                <a href="/products/acrylic/template/Acrylic-board-template.zip">テンプレートダウンロード</a>
                            </td>
                        </tr>
                    </table>
    
    				<table class="アクリルスタンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_50mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_75mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_stand_100mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルスマホスタンド">
    					<tr>
    						<td class="left">150mm×90mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_smartphone_stand_20220607.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_smartphone_stand_20220607.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルスマホスタンド">
    					<tr>
    						<td class="left">150mm×90mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_smartphone_stand_20220607.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="めじるしチャーム（アクリルアンブレラマーカー）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				<table class="めじるしチャーム（アクリルアンブレラマーカー）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_50mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_75mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_umbrella_100mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルクリップ（アクリルバッジ）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_50mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_clip_50mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_75mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_clip_75mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_100mm_20250320.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_clip_100mm_20250320.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				<table class="アクリルクリップ（アクリルバッジ）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_50mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_75mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">100mm×100mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_clip_100mm_20250320.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルコースター">
    					<tr>
    						<td class="left">90mm×90mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_coaster_20200626.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_coaster.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				<table class="アクリルコースター">
    					<tr>
    						<td class="left">90mm×90mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_coaster.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルヘアバンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_hair.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-acrylic_hair.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				<table class="アクリルヘアバンド">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-acrylic_hairband.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="アクリルスマホグリップトック（アクリルグリップホルダー）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-griptok_50x50mm.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-griptok_50x50mm.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-griptok_75x75mm.ai">テンプレートダウンロードai</a>
    							<a href="/products/download/download.php?fname=template-griptok_75x75mm.psd">テンプレートダウンロードpsd</a>
    						</td>
    					</tr>
    				</table>
    				<table class="アクリルスマホグリップトック（アクリルグリップホルダー）">
    					<tr>
    						<td class="left">50mm×50mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-griptok_50x50mm.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    					<tr>
    						<td class="left">75mm×75mm</td>
    						<td class="right">
    							<a href="/products/download/download.php?fname=template-griptok_75x75mm.clip">テンプレートダウンロードclip</a>
    						</td>
    					</tr>
    				</table>
    
    				<table class="テンチャックケース">
    					<tbody>
    						<tr>
    							<td class="left">テンチャックケース</td>
    							<td class="right">
    								<a href="/products/download/download.php?fname=template_pouch.ai">テンプレートダウンロードai
    			</div>
    			</a>
    			<a href="/products/download/download.php?fname=template_pouch.psd">テンプレートダウンロードpsd
    		</div>
    		</a>
    		</td>
    		</tr>
    		</tbody>
    		</table>
    		<table class="テンチャックケース">
    			<tbody>
    				<tr>
    					<td class="left">テンチャックケース</td>
    					<td class="right">
    						<a href="/products/download/download.php?fname=template_pouch.clip">テンプレートダウンロードclip
    	</div>
    	</a>
    	</td>
    	</tr>
    	</tbody>
    	</table>
    
    	<table class="反射リストバンド">
    		<tr>
    			<td class="left">30mmx230mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=wristband-01.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="マイクロファイバーメガネクロス">
    		<tr>
    			<td class="left">150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber_150X150mm.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_150X150mm.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">180mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber_180X150mm.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_180X150mm.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    	</table>
    	<table class="マイクロファイバーポーチ">
    		<tr>
    			<td class="left">90mmx180mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template-Pouch_90x180.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">100mmx180mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template-Pouch_100x180.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="リサイクル原糸マイクロファイバークロス">
    		<tr>
    			<td class="left">150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber recycle-cloth_150X150mm.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">180mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber recycle-cloth_180X150mm.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="オリジナルメガネクロス">
    		<tr>
    			<td class="left">150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber cleaner_150X150mm.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">180mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_microfiber cleaner_180X150mm.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="オリジナルメガネケース">
    		<tr>
    			<td class="left">160mmx60mmx40mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_glasses case.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="スタビーホルダー">
    		<tr>
    			<td class="left">95mmx100mm(SBR)</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_Stubby_SBR.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">105mmx110mm(スポンジ)</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=Template_Stubby_sponge.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="オリジナルビーチサンダル">
    		<tr>
    			<td class="left">S:M:L(枠なし)</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=枠なしテンプレート.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">S:M:L(枠あり)</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=枠ありテンプレート.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="携帯灰皿ノベルティ製作">
    		<tr>
    			<td class="left">80mmx80mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=haizara_20210514.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="オリジナル名入れカラビナ">
    		<tr>
    			<td class="left">Mサイズ(60mm)とLサイズ(70mm)</td>
    			<td class="right">
    				<a href="/products/carabiner/template-carabiner.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="オリジナル保冷剤">
    		<tr>
    			<td class="left">オリジナル保冷剤</td>
    			<td class="right">
    				<a href="/products/download/template-coolpack.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="スマホクリーナー（ラバストタイプ）">
    		<tr>
    			<td class="left">スマホクリーナー（ラバストタイプ）</td>
    			<td class="right">
    				<a href="/products/rubbercleaner/download/download.php?fname=template_rubber_mobile_cleaner.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="ラバースマートフォンスタンド">
    		<tr>
    			<td class="left">小サイズ：182.5mmX95mm</td>
    			<td class="right">
    				<a href="/products/download.php?file=download_smartphone_S.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">大サイズ：236mmX120mm</td>
    			<td class="right">
    				<a href="/products/download.php?file=download_iphone6.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="リフレクターシール">
    		<tr>
    			<td class="left">リフレクターシール</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=sticker.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="フローティングキーホルダー">
    		<tr>
    			<td class="left">フローティングキーホルダー</td>
    			<td class="right">
    				<a href="/products/download/template-EVA%20keychain.zip?v=1">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="キッチンスポンジ">
    		<tr>
    			<td class="left">キッチンスポンジ</td>
    			<td class="right">
    				<a href="/products/download/Template_Sponge.zip?v=1">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="フライトタグ">
    		<tr>
    			<td class="left">フライトタグ</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template-flight_tag_20260423_OL.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=template-flight_tag_20260423_OL.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    	</table>
    	<table class="ワッペン・パッチ">
    		<tr>
    			<td class="left">ワッペン・パッチ</td>
    			<td class="right">
    				<a href="/products/download/download?fname=template-flighttag-wappen_20231215.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="刺繍キーホルダー">
    		<tr>
    			<td class="left">刺繍キーホルダー</td>
    			<td class="right">
    				<a href="/products/download/download?fname=template-flighttag_20231214.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="刺繍バッジ">
    		<tr>
    			<td class="left">刺繍バッジ</td>
    			<td class="right">
    				<a href="/products/download/download?fname=template-flighttag-badge_20231215.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="刺繍コースター">
    		<tr>
    			<td class="left">刺繍コースター</td>
    			<td class="right">
    				<a href="/products/download/download?fname=template-flighttag-coaster_20231215.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="マイクロファイバーマウスパッド">
    		<tr>
    			<td class="left">マイクロファイバーマウスパッド</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template_mouse_pad_20191212.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
        <table class="クッションポーチ">
    		<tr>
    			<td class="left">100mmx150mm／160mmx204mm</td>
    			<td class="right">
    				<a href="/products/aircusshion-pouch/template/template_puchipuchipouch.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
        <table class="お守り">
    		<tr>
    			<td class="left">50mmx80mm</td>
    			<td class="right">
    				<a href="/products/new-template/omamori_l_template_20260707_1310.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
         <table class="タペストリー（A2・B2・B1）">
    		<tr>
    			<td class="left">A2サイズ</td>
    			<td class="right">
    				<a href="/products/tapestry/template/template_tapestry_A2_20251002.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
            <tr>
    			<td class="left">B2サイズ</td>
    			<td class="right">
    				<a href="/products/tapestry/template/template_tapestry_B2_20251002.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
            <tr>
    			<td class="left">B1サイズ</td>
    			<td class="right">
    				<a href="/products/tapestry/template/template_tapestry_B1_20251002.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
        <table class="デスクマット">
    		<tr>
    			<td class="left">300mm×550mm</td>
    			<td class="right">
    				<a href="/products/new-template/Deskmat_550x300_template_20260313.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
            <tr>
    			<td class="left">350mm×600mm</td>
    			<td class="right">
    				<a href="/products/new-template/Deskmat_600x350_template_20260313.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
        <table class="タンブラー">
    		<tr>
    			<td class="left">レーザー加工／フルカラー印刷</td>
    			<td class="right">
    				<a href="/products/tumbler/template/tumbler-template.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
        <table class="ボトルオープナー">
    		<tr>
    			<td class="left">62.5mm×12mm</td>
    			<td class="right">
    				<a href="/products/new-template/template-bottleopener_20260312.ai">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
    	<table class="マイクロファイバークロススウェード生地">
    		<tr>
    			<td class="left">バージン材 150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A0Template_microfiber_150X150mm_MKI.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_150X150mm_MKI.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">バージン材 150mmx180mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A1Template_microfiber_180X150mm_MKI.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_180X150mm_MKI.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">リサイクル材 150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A2Template_microfiber_150X150mm_MKI-50.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_150X150mm_MKI-50.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">リサイクル材 150mmx180mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A3Template_microfiber_180X150mm_MKI-50.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_180X150mm_MKI-50.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    	</table>
    	<table class="マイクロファイバークロス100％リサイクルポリエステル">
    		<tr>
    			<td class="left">バージン材 150mmx150mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A4Template_microfiber_150X150mm_SLM100.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_150X150mm_SLM100.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    		<tr>
    			<td class="left">バージン材 150mmx180mm</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=%E2%91%A5Template_microfiber_180X150mm_SLM100.pdf">テンプレートダウンロードpdf</a>
    				<a href="/products/download/download.php?fname=Template_microfiber_180X150mm_SLM100.ai">テンプレートダウンロードai</a>
    			</td>
    		</tr>
    	</table>
    	<table class="エコカイロ">
    		<tr>
    			<td class="left">エコカイロ</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template-ecokairo.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="スマホ手袋">
    		<tr>
    			<td class="left">スマホ手袋</td>
    			<td class="right">
    				<a href="/products/new-template/template_gloves_20260313.pdf" download>テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="コンパクトジョグボトル">
    		<tr>
    			<td class="left">コンパクトジョグボトル</td>
    			<td class="right">
    				<a href="/products/new-template/template_JOGBOTTLE_20260313.pdf" download>テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    	<table class="防水ケース">
    		<tr>
    			<td class="left">防水ケース</td>
    			<td class="right">
    				<a href="/products/download/download.php?fname=template-bosui.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    	</table>
    
    	<table class="台紙">
    		<tr>
    			<td class="left">各種サイズ（50×50mm／75×75mm／100×100mm／130×100mm／180×100mm</td>
    			<td class="right">
    				<a href="/products/download/台紙テンプレートサイズ個別分けai.zip">テンプレートダウンロード</a>
    			</td>
    		</tr>
    		</table>
				@endif
    
    	</div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const usesManagedTemplates = @json($usesManagedTemplates);
            const initialTemplate = @json((string) request()->query('temp', ''));
            const templateAliases = {
                acrylic_keyholder: 'オーロラアクリルキーホルダー',
                acrylic_stand: 'オーロラアクリルスタンド',
                acrylic_coaster: 'アクリルコースター',
                acrylic_phonestand: 'アクリルスマホスタンド',
                acrylic_hair: 'アクリルヘアバンド',
                acrylic_griptok: 'アクリルスマホグリップトック（アクリルグリップホルダー）',
                acrylic_board: 'アクリルパネル（アクリルボード）',
                free: 'アクリルクリップ（アクリルバッジ）'
            };
            const initialProduct = templateAliases[initialTemplate] || '';

            if (usesManagedTemplates) {
                $('#prd_name').on('change', function () {
                    const productId = this.value;
                    $('#result').hide();
                    $('#result .template-product-result').hide();

                    if (!productId) return;

                    $('#result').show();
                    $('#result .template-product-result[data-product-id="' + productId + '"]').show();
                });

                if (initialProduct) {
                    const initialOption = $('#prd_name option').filter(function () {
                        return $(this).data('product-name') === initialProduct;
                    }).first();

                    if (initialOption.length) {
                        $('#prd_name').val(initialOption.val()).trigger('change');
                    }
                }

                return;
            }

            $('#prd_name').on('change', function () {
                $('#result').hide();
                $('#result table').hide();

                if (!this.value) {
                    return;
                }

                $('#result').show();
                $('#result h3.csp').remove();
                $('#result h3').text(this.value + '【Illustrator】');

                const photoshopProducts = [
                    'アクリルキーホルダー',
                    'アクリルフィギュアスタンド',
                    'アクリルスタンド',
                    'アクリルスマホスタンド',
                    'めじるしチャーム（アクリルアンブレラマーカー）',
                    'アクリルクリップ（アクリルバッジ）',
                    'アクリルコースター',
                    'アクリルヘアバンド',
                    'アクリルスマホグリップトック（アクリルグリップホルダー）',
                    'テンチャックケース'
                ];

                if (photoshopProducts.includes(this.value)) {
                    $('#result h3').text(this.value + '【Illustrator／Photoshop】');
                    $('#result table.' + this.value).first().after("<h3 class='csp'></h3>");
                    $('#result h3.csp').text('【CLIP STUDIO PAINT】');
                }

                if (this.value === 'オリジナルメガネクロス') {
                    $('#result h3').text('オリジナルメガネクロス（裏面タオル地）【Illustrator】');
                }

                $('#result table.' + this.value).show();
            });

            if (initialProduct) {
                $('#prd_name').val(initialProduct).trigger('change');
            }
        });
    </script>
@endpush
