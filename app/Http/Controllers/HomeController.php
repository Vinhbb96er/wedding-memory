<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private function getBaseData()
    {
        return [
            'slider_content' => [
                'ja_text_1' => '一生のなかで、心から大好きになれる人は、そう多くない。',
                'ja_text_2' => '「好き」って思える人と出会えたこと。それはもう奇跡です。',
            ],
            'slider_images' => [
                'images/weddings/sliders/wedding_slider_1.jpg',
                'images/weddings/sliders/wedding_slider_2.jpg',
                'images/weddings/sliders/wedding_slider_3.jpg',
                'images/weddings/sliders/wedding_slider_4.jpg',
                'images/weddings/sliders/wedding_slider_5.jpg',
                'images/weddings/sliders/wedding_slider_6.jpg',
                'images/weddings/sliders/wedding_slider_7.jpg',
            ],
            'music_link' => 'audio/music.mp3',
            'time_now' => Carbon::now()->format('Y-m-d H:i:s'),
            'wedding_events' => [
                [
                    'title' => 'Lễ Vu Quy',
                    'date_time' => '2022-11-13 07:00:00',
                    'date' => '2022/11/13',
                    'time' => '07:00',
                    'icon' => './images/icons/rings.png',
                    'is_active' => true,
                ],
                [
                    'title' => 'Lễ Thành Hôn',
                    'date_time' => '2022-11-13 09:00:00',
                    'date' => '2022/11/13',
                    'time' => '09:00',
                    'icon' => './images/icons/wedding-arch.png',
                    'is_active' => true,
                ],
                [
                    'title' => 'Đón Khách',
                    'date_time' => '2022-12-31 10:30:00',
                    'date' => '2022/12/31',
                    'time' => '10:30',
                    'icon' => './images/icons/wedding-couple.png',
                    'is_active' => false,
                ],
                [
                    'title' => 'Tiệc',
                    'date_time' => '2022-12-31 11:00:00',
                    'date' => '2022/12/31',
                    'time' => '11:00',
                    'icon' => './images/icons/wine.png',
                    'is_active' => false,
                ],
                [
                    'title' => 'Lưu Niệm',
                    'date_time' => '2022-12-31 13:00:00',
                    'date' => '2022/12/31',
                    'time' => '13:00',
                    'icon' => './images/icons/camera.png',
                    'is_active' => false,
                ]
            ],
            'countdown' => [
                'image_link' => 'images/weddings/counting-down-image.jpg',
                'place' => 'MINH CHÂU VIỆT / SẢNH A - 456 NGUYỄN TRI PHƯƠNG, HẢI CHÂU, ĐÀ NẴNG',
            ],
            'memories' => [
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ],
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ],
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ],
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ],
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ],
                [
                    'image_link' => 'https://picsum.photos/300/400',
                    'hashtags' => ['2022/12/12', 'hue'],
                ]
            ],
            'couple' => [
                'v_image_link' => 'images/weddings/single-v.jpg',
                'v_image_qr_code_link' => 'images/icons/v-qr-code.png',
                'v_cc_info' => 'Techcombank - 19036816252011',
                'u_image_link' => 'images/weddings/single-u.jpg',
                'u_image_qr_code_link' => 'images/icons/u-qr-code.png',
                'u_cc_info' => 'VietinBank - 109005626989',
            ],
            'thank_you' => [
                'image_link' => 'images/weddings/thankyou.jpg'
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        try {
            $data = $this->getBaseData();

            return view('home', compact('data'));
        } catch (\Exception $e) {
            abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $params = $request->only('name', 'content', 'type');

            if (empty($params['name']) && empty($params['content'])) {
                return;
            }

            $params['type'] = $params['type'] == 'v' ? 'Bạn Vĩnh' : 'Bạn Uyên';
            $fileName = 'data.csv';

            if (!file_exists(storage_path($fileName))) {
                $fp = fopen(storage_path($fileName), 'a');
                fputcsv($fp, ["Name","Content","Type"]);
            }

            $fp = fopen(storage_path($fileName), 'a');
            fputcsv($fp, [$params['name'], $params['content'], $params['type']]);
        } catch (\Exception $e) {
            abort(500);
        }
    }
}
