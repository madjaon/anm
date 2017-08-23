<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Models\Post;
use App\Helpers\CommonMethod;

use Sunra\PhpSimple\HtmlDomParser;

class TestController extends Controller
{
    public function index()
    {
        self::insertData();

        dd('no permission');

        return view('site.test');
        
        // $array1 = [
        //     'Xebec',
        //     'Studio Gallop'
        // ];
        // $array = [
            // '1' => '3xCube',
            // '2' => '8bit',
            // '3' => 'A.C.G.T.',
            // '4' => 'A-1 Pictures',
            // '5' => 'Actas',
            // '6' => 'AIC',
            // '7' => 'AIC A.S.T.A.',
            // '8' => 'AIC Build',
            // '9' => 'AIC Classic',
            // '10' => 'AIC Plus+',
            // '11' => 'AIC Spirits',
            // '12' => 'Ajia-Do',
            // '13' => 'Arms',
            // '14' => 'Artland',
            // '15' => 'Asahi Production',
            // '16' => 'Asread',
            // '17' => 'AXsiZ',
            // '18' => 'Bandai Namco Pictures',
            // '19' => 'Barnum Studio',
            // '20' => 'Bee Media',
            // '21' => 'Bee Train',
            // '22' => 'Bones',
            // '23' => 'Brain\'s Base',
            // '24' => 'Bridge',
            // '25' => 'C2C',
            // '26' => 'CoMix Wave Films',
            // '27' => 'Connect',
            // '28' => 'Creators in Pack',
            // '29' => 'C-Station',
            // '30' => 'Daume',
            // '31' => 'David Production',
            // '32' => 'Diomedea',
            // '33' => 'DMM.futureworks',
            // '34' => 'Doga Kobo',
            // '35' => 'Egg Firm',
            // '36' => 'EMT²',
            // '37' => 'Encourage Films',
            // '38' => 'Fanworks',
            // '39' => 'feel.',
            // '40' => 'Fuji TV',
            // '41' => 'Gainax',
            // '42' => 'GEMBA',
            // '43' => 'GoHands',
            // '44' => 'Gonzo',
            // '45' => 'Graphinica',
            // '46' => 'Group TAC',
            // '47' => 'Hal Film Maker',
            // '48' => 'Haoliners Animation League',
            // '49' => 'Hoods Drifters Studio',
            // '50' => 'Hoods Entertainment',
            // '51' => 'ILCA',
            // '52' => 'Imagin',
            // '53' => 'Will Palette',
            // '54' => 'J.C.Staff',
            // '55' => 'Kinema Citrus',
            // '56' => 'KOO-KI',
            // '57' => 'Kyoto Animation',
            // '58' => 'Lay-duce',
            // '59' => 'Lerche',
            // '60' => 'LIDENFILMS',
            // '61' => 'M2',
            // '62' => 'Madhouse',
            // '63' => 'Manglobe',
            // '64' => 'MAPPA',
            // '65' => 'Namu Animation',
            // '66' => 'NAZ',
            // '67' => 'Nexus',
            // '68' => 'Nippon Animation',
            // '69' => 'Nomad',
            // '70' => 'NUT',
            // '71' => 'Office DCI',
            // '72' => 'OLM',
            // '73' => 'Orange',
            // '74' => 'Ordet',
            // '75' => 'P.A. Works',
            // '76' => 'Palm Studio',
            // '77' => 'Passione',
            // '78' => 'Pierrot Plus',
            // '79' => 'Pine Jam',
            // '80' => 'Platinum Vision',
            // '81' => 'Polygon Pictures',
            // '82' => 'Production I.G',
            // '83' => 'Production IMS',
            // '84' => 'Production Reed',
            // '85' => 'Project No.9',
            // '86' => 'Radix',
            // '87' => 'SANZIGEN',
            // '88' => 'Satelight',
            // '89' => 'Seven',
            // '90' => 'Seven Arcs',
            // '91' => 'Seven Arcs Pictures',
            // '92' => 'Shaft',
            // '93' => 'Shin-Ei Animation',
            // '94' => 'Shuka',
            // '95' => 'Silver Link.',
            // '96' => 'Studio 3Hz',
            // '97' => 'Studio Comet',
            // '98' => 'Studio Deen',
            // '99' => 'Studio Gallop',
            // '100' => 'Studio Gokumi',
            // '101' => 'Studio Hibari',
            // '102' => 'Studio Pierrot',
            // '103' => 'Sunrise',
            // '104' => 'SynergySP',
            // '105' => 'Tatsunoko Production',
            // '106' => 'Telecom Animation Film',
            // '107' => 'Tezuka Productions',
            // '108' => 'TMS Entertainment',
            // '109' => 'TNK',
            // '110' => 'Toei Animation',
            // '111' => 'Trans Arts',
            // '112' => 'Triangle Staff',
            // '113' => 'Trigger',
            // '114' => 'TROYCA',
            // '115' => 'Tsuchida Productions',
            // '116' => 'TYO Animations',
            // '117' => 'TYPHOON GRAPHICS',
            // '118' => 'ufotable',
            // '119' => 'White Fox',
            // '120' => 'Wit Studio',
            // '121' => 'Xebec',
            // '122' => 'Yaoyorozu',
            // '123' => 'Zero-G',
            // '124' => 'Zexcs',
            // '125' => 'BeSTACK',
            // '126' => 'Remic',
            // '127' => 'Studio Blanc',
            // '128' => 'Marvy Jack',
            // '129' => 'W-Toon Studio',
            // '130' => 'Shirogumi',
            // '131' => 'Millepensee',
            // '132' => 'Picture Magic',
            // '133' => 'Studio Ghibli',
            // '134' => 'Signal. MD',
            // '135' => 'Studio VOLN',
            // '136' => 'M.S.C',
            // '137' => 'ixtl',
            // '138' => 'Studio Ponoc',
            // '139' => 'Marza Animation Planet',
            // '140' => 'Science SARU',
            // '141' => 'JUMONJI',
            // '142' => 'Qualia Animation',
            // '143' => 'Digital Frontier',
            // '144' => 'Square Enix',
            // '145' => 'Digic Pictures',
            // '146' => 'B&T',
            // '147' => 'Studio 4°C',
            // '148' => 'Studio Chizu',
            // '149' => 'Sola Digital Arts',
            // '150' => 'Studio Rikka',
            // '151' => 'Studio Colorido',
            // '152' => 'Rockwell Eyes',
            // '153' => 'Steve N\' Steven',
            // '154' => 'Geno Studio',
            // '155' => 'Purple Cow Studio Japan',
            // '156' => 'Yamato Works',
            // '157' => 'Ascension',
            // '158' => 'Tokyo Movie Shinsha',
            // '159' => 'Khara',
            // '160' => 'Think Corporation',
            // '161' => 'Oh! Production',
            // '162' => 'The Answer Studio',
            // '163' => 'APPP',
            // '164' => 'LandQ studios',
            // '165' => 'Arcs Create',
            // '166' => 'Shinkuukan',
            // '167' => 'Chaos Project',
            // '168' => 'Studio Fantasia',
            // '169' => 'Gathering',
            // '170' => 'Anpro',
            // '171' => 'Studio Animal',
            // '172' => 'Kamikaze Douga',
            // '173' => 'Studio PuYUKAI',
            // '174' => 'An DerCen',
            // '175' => 'Felix Film',
            // '176' => 'Xebec Zwei',

        // ];

        // $result = [];

        // foreach($array1 as $key => $value) {
        //     if(strpos($value, ',') === false) {
        //         $result[$key] = array_search($value, $array);
        //     } else {
        //         $result[$key] = '';
        //         $value_explode = explode(',', $value);
        //         foreach($value_explode as $k => $v) {
        //             if($k > 0) {
        //                 $result[$key] .= ',' . array_search(trim($v), $array);
        //             } else {
        //                 $result[$key] .= array_search(trim($v), $array);
        //             }
                    
        //         }
        //     }
        // }

        // dd($result);
        
        ////////////////////////////////////////
        //check posts va post_type_relations co trung du lieu hay ko
        // $posts = DB::table('posts')->lists('id');
        // $post_type_relations = DB::table('post_type_relations')->groupBy('post_id')->lists('post_id');
        // $count_posts = count($posts);
        // $count_post_type_relations = count($post_type_relations);
        // if($count_post_type_relations > 0 && $count_posts > 0) {
        //     foreach($post_type_relations as $value) {
        //         if(!in_array($value, $posts)) {
        //             echo $value . '<br>';
        //         }
        //     }
        // }
        // dd($count_post_type_relations);
        //END
        ////////////////////////////////////////
    }

    /**

    CREATE TABLE `ani_anilists` (
      `id` int(11) NOT NULL,
      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `name2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `year` int(11) NOT NULL,
      `season` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `episode` int(11) NOT NULL,
      `type` int(11) NOT NULL,
      `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `genre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='test';

    ALTER TABLE `ani_anilists` ADD PRIMARY KEY (`id`);

    ALTER TABLE `ani_anilists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

    **/

    public function animeSteal(Request $request)
    {
        trimRequest($request);

        $html = HtmlDomParser::str_get_html($request->htmlstring); // Create DOM from URL or file

        $genres = [];
        $titles = [];
        $producers = [];
        $eps = [];

        foreach($html->find('.seasonal-anime') as $element) {
            $genres[] = trim($element->getAttribute('data-genre'));
        }
        foreach($html->find('.title-text') as $element) {
            $titles[] = trim($element->plaintext);
        }
        foreach($html->find('span.producer') as $element) {
            $producers[] = self::getIdTag(trim($element->plaintext));
        }
        foreach($html->find('div.eps') as $element) {
            $eps[] = str_replace(' eps', '', trim($element->plaintext));
        }
        foreach($html->find('div.scormem span.member') as $element) {
            $member[] = str_replace(',', '', trim($element->plaintext));
        }
        foreach($html->find('div.scormem span.score') as $element) {
            $score[] = round(trim($element->plaintext)); // lam tron tren duoi .5
            // $score[] = floor(trim($element->plaintext)); // lam tron giam xuong phan so nguyen
        }

        if(count($titles) > 0) {
            foreach($titles as $key => $value) {
                if($score[$key] > 6 && $member[$key] > 25000) {
                    $check = DB::table('anilists')->where('name', $value)->first();
                    if(strpos($genres[$key], '12') !== false || strpos($genres[$key], '33') !== false || strpos($genres[$key], '34') !== false ) {
                        $checkGenre = 1;
                    } else {
                        $checkGenre = null;
                    }
                    // if($eps[$key] == 1) {
                        $kind = 'da-hoan-thanh';
                    // } else {
                    //     $kind = 'con-tiep-tuc';
                    // }
                    if(!isset($check) && !isset($checkGenre)) {
                        DB::table('anilists')->insert([
                            'name' => $value, // ten phim
                            // 'name2' => '', // ten khac
                            'year' => $request->year, // nam
                            'season' => $request->season, // mua
                            'episode' => $eps[$key], // so tap
                            // 'type' => $request->type, // loai phim
                            // 'kind' => $request->kind, // tinh trang
                            'type' => 3, // loai phim
                            'kind' => $kind, // tinh trang
                            'tag' => $producers[$key], // hang phim
                            'genre' => $genres[$key] // the loai
                        ]);
                    }
                }
            }
        }
        return redirect('test')->with('success', 'Thành công');
        // dd('success!');
    }

    // $string studios
    private function getIdTag($string)
    {
        $array = [
            '1' => '3xCube',
            '2' => '8bit',
            '3' => 'A.C.G.T.',
            '4' => 'A-1 Pictures',
            '5' => 'Actas',
            '6' => 'AIC',
            '7' => 'AIC A.S.T.A.',
            '8' => 'AIC Build',
            '9' => 'AIC Classic',
            '10' => 'AIC Plus+',
            '11' => 'AIC Spirits',
            '12' => 'Ajia-Do',
            '13' => 'Arms',
            '14' => 'Artland',
            '15' => 'Asahi Production',
            '16' => 'Asread',
            '17' => 'AXsiZ',
            '18' => 'Bandai Namco Pictures',
            '19' => 'Barnum Studio',
            '20' => 'Bee Media',
            '21' => 'Bee Train',
            '22' => 'Bones',
            '23' => 'Brain\'s Base',
            '24' => 'Bridge',
            '25' => 'C2C',
            '26' => 'CoMix Wave Films',
            '27' => 'Connect',
            '28' => 'Creators in Pack',
            '29' => 'C-Station',
            '30' => 'Daume',
            '31' => 'David Production',
            '32' => 'Diomedea',
            '33' => 'DMM.futureworks',
            '34' => 'Doga Kobo',
            '35' => 'Egg Firm',
            '36' => 'EMT²',
            '37' => 'Encourage Films',
            '38' => 'Fanworks',
            '39' => 'feel.',
            '40' => 'Fuji TV',
            '41' => 'Gainax',
            '42' => 'GEMBA',
            '43' => 'GoHands',
            '44' => 'Gonzo',
            '45' => 'Graphinica',
            '46' => 'Group TAC',
            '47' => 'Hal Film Maker',
            '48' => 'Haoliners Animation League',
            '49' => 'Hoods Drifters Studio',
            '50' => 'Hoods Entertainment',
            '51' => 'ILCA',
            '52' => 'Imagin',
            '53' => 'Will Palette',
            '54' => 'J.C.Staff',
            '55' => 'Kinema Citrus',
            '56' => 'KOO-KI',
            '57' => 'Kyoto Animation',
            '58' => 'Lay-duce',
            '59' => 'Lerche',
            '60' => 'LIDENFILMS',
            '61' => 'M2',
            '62' => 'Madhouse',
            '63' => 'Manglobe',
            '64' => 'MAPPA',
            '65' => 'Namu Animation',
            '66' => 'NAZ',
            '67' => 'Nexus',
            '68' => 'Nippon Animation',
            '69' => 'Nomad',
            '70' => 'NUT',
            '71' => 'Office DCI',
            '72' => 'OLM',
            '73' => 'Orange',
            '74' => 'Ordet',
            '75' => 'P.A. Works',
            '76' => 'Palm Studio',
            '77' => 'Passione',
            '78' => 'Pierrot Plus',
            '79' => 'Pine Jam',
            '80' => 'Platinum Vision',
            '81' => 'Polygon Pictures',
            '82' => 'Production I.G',
            '83' => 'Production IMS',
            '84' => 'Production Reed',
            '85' => 'Project No.9',
            '86' => 'Radix',
            '87' => 'SANZIGEN',
            '88' => 'Satelight',
            '89' => 'Seven',
            '90' => 'Seven Arcs',
            '91' => 'Seven Arcs Pictures',
            '92' => 'Shaft',
            '93' => 'Shin-Ei Animation',
            '94' => 'Shuka',
            '95' => 'Silver Link.',
            '96' => 'Studio 3Hz',
            '97' => 'Studio Comet',
            '98' => 'Studio Deen',
            '99' => 'Studio Gallop',
            '100' => 'Studio Gokumi',
            '101' => 'Studio Hibari',
            '102' => 'Studio Pierrot',
            '103' => 'Sunrise',
            '104' => 'SynergySP',
            '105' => 'Tatsunoko Production',
            '106' => 'Telecom Animation Film',
            '107' => 'Tezuka Productions',
            '108' => 'TMS Entertainment',
            '109' => 'TNK',
            '110' => 'Toei Animation',
            '111' => 'Trans Arts',
            '112' => 'Triangle Staff',
            '113' => 'Trigger',
            '114' => 'TROYCA',
            '115' => 'Tsuchida Productions',
            '116' => 'TYO Animations',
            '117' => 'TYPHOON GRAPHICS',
            '118' => 'ufotable',
            '119' => 'White Fox',
            '120' => 'Wit Studio',
            '121' => 'Xebec',
            '122' => 'Yaoyorozu',
            '123' => 'Zero-G',
            '124' => 'Zexcs',
            '125' => 'BeSTACK',
            '126' => 'Remic',
            '127' => 'Studio Blanc',
            '128' => 'Marvy Jack',
            '129' => 'W-Toon Studio',
            '130' => 'Shirogumi',
            '131' => 'Millepensee',
            '132' => 'Picture Magic',
            '133' => 'Studio Ghibli',
            '134' => 'Signal. MD',
            '135' => 'Studio VOLN',
            '136' => 'M.S.C',
            '137' => 'ixtl',
            '138' => 'Studio Ponoc',
            '139' => 'Marza Animation Planet',
            '140' => 'Science SARU',
            '141' => 'JUMONJI',
            '142' => 'Qualia Animation',
            '143' => 'Digital Frontier',
            '144' => 'Square Enix',
            '145' => 'Digic Pictures',
            '146' => 'B&T',
            '147' => 'Studio 4°C',
            '148' => 'Studio Chizu',
            '149' => 'Sola Digital Arts',
            '150' => 'Studio Rikka',
            '151' => 'Studio Colorido',
            '152' => 'Rockwell Eyes',
            '153' => 'Steve N\' Steven',
            '154' => 'Geno Studio',
            '155' => 'Purple Cow Studio Japan',
            '156' => 'Yamato Works',
            '157' => 'Ascension',
            '158' => 'Tokyo Movie Shinsha',
            '159' => 'Khara',
            '160' => 'Think Corporation',
            '161' => 'Oh! Production',
            '162' => 'The Answer Studio',
            '163' => 'APPP',
            '164' => 'LandQ studios',
            '165' => 'Arcs Create',
            '166' => 'Shinkuukan',
            '167' => 'Chaos Project',
            '168' => 'Studio Fantasia',
            '169' => 'Gathering',
            '170' => 'Anpro',
            '171' => 'Studio Animal',
            '172' => 'Kamikaze Douga',
            '173' => 'Studio PuYUKAI',
            '174' => 'An DerCen',
            '175' => 'Felix Film',
            '176' => 'Xebec Zwei',

        ];

        $result = '';

        if(strpos($string, ',') === false) {
            $result = array_search(trim($string), $array);
        } else {
            $explode = explode(',', $string);
            foreach($explode as $k => $v) {
                if($k > 0) {
                    $result .= ',' . array_search(trim($v), $array);
                } else {
                    $result .= array_search(trim($v), $array);
                }
                
            }
        }

        return $result;
    }

    // warning: this function is dangerous
    // check bai viet trung nhau va lam 1 so thu khac
    // viet xong gio quen roi, doc lai code de biet
    //vlue = 28: type id 28. 
    public function mixdb($typeId=28)
    {
        dd('disabled');
        $ps = DB::table('posts')
                ->select('id', 'slug', 'type_main_id', DB::raw('COUNT(*) as c'))
                ->groupBy('slug')
                ->having('c', '>', 1)
                ->orderBy('c', 'desc')
                ->get();
        dd($ps);
        if(count($ps) > 0) {
            $ids = [];
            foreach($ps as $key => $value) {
                $ids[$key] = DB::table('posts')
                    ->where('slug', $value->slug)
                    ->lists('id');
                if(count($ids[$key]) > 0 && $value->c > 2) {
                    $firstId = $ids[$key][0];
                    $allbutfirst = array_slice($ids[$key], 1);
                    //delete post_type_relations
                    DB::table('post_type_relations')->whereIn('post_id', $ids[$key])->delete();
                    //insert post_type_relations with type = $typeId
                    DB::table('post_type_relations')->insert(['post_id' => $firstId, 'type_id' => $typeId]);
                    //delete posts duplicate posts except first in list
                    DB::table('posts')->whereIn('id', $allbutfirst)->delete();
                    //update first post typemainid = $typeId
                    DB::table('posts')->where('id', $firstId)->update(['type_main_id' => $typeId]);
                }
                if(count($ids[$key]) > 0 && $value->c == 2) {
                    $firstId = $ids[$key][0];
                    $secondId = $ids[$key][1];
                    //delete second post
                    DB::table('posts')->where('id', $secondId)->delete();
                    // update post type relation post id to first post id
                    DB::table('post_type_relations')->where('post_id', $secondId)->update(['post_id' => $firstId]);
                }
            }
            dd('End mix. Please, Check database now');
        } else {
            dd('no record');
        }
    }

    private function insertData()
    {
        // $images = array();
        // $images = self::getimageswithdir('images/ova/', INACTIVE);
        // if(count($images) > 0) {
        //     foreach($images as $key => $value) {
        //         $filepath1 = public_path().$value;
        //         $name = basename($value);
        //         $name = CommonMethod::changeFileNameImage($name, 1);
        //         $filepath2 = public_path().'/images/ova/'.$name;
        //         rename($filepath1, $filepath2);
        //     }
        // }
        // dd('ok!!!');

        // [name,image,name2,year,season,episode,type,kind,genres,tags,seri,date]
        // 2000
        $array = [['Doraemon','/images/2000/thumb/Doraemon_1979.jpg','Mèo Máy Doraemon','1979','dong','1787','1','da-hoan-thanh','15,2,10,4,24,27','93','71','2017-08-23 00:00:00'],['Mobile Suit Gundam','/images/2000/thumb/Mobile_Suit_Gundam.jpg','Kidou Senshi Gundam','1979','xuan','43','1','da-hoan-thanh','1,38,24,29,18','103','7','2017-08-23 00:00:01'],['Captain Tsubasa','/images/2000/thumb/Captain_Tsubasa.jpg','Flash Kicker, Đội Trưởng Tsubasa','1983','thu','128','1','da-hoan-thanh','1,27,30','115','191','2017-08-23 00:00:02'],['Dragon Ball','/images/2000/thumb/Dragon_Ball.jpg','Bảy Viên Ngọc Rồng','1986','dong','153','1','da-hoan-thanh','2,4,31,17,10,27','110','2','2017-08-23 00:00:03'],['City Hunter','/images/2000/thumb/City_Hunter.jpg','Thợ Săn Thành Phố','1987','xuan','51','1','da-hoan-thanh','1,4,7,27','103','89','2017-08-23 00:00:04'],['City Hunter 2','/images/2000/thumb/City_Hunter_2.jpg','Thợ Săn Thành Phố 2','1988','xuan','63','1','da-hoan-thanh','1,4,7,27','103','89','2017-08-23 00:00:05'],['Dragon Ball Z','/images/2000/thumb/Dragon_Ball_Z.jpg','Bảy Viên Ngọc Rồng Z','1989','xuan','291','1','da-hoan-thanh','1,2,4,10,17,27,31','110','2','2017-08-23 00:00:06'],['Ranma ½','/images/2000/thumb/Ranma_%C2%BD.jpg','1 Nửa Ranma','1989','xuan','161','1','da-hoan-thanh','36,4,17,10','98','','2017-08-23 00:00:07'],['City Hunter 3','/images/2000/thumb/City_Hunter_3.jpg','Thợ Săn Thành Phố 3','1989','thu','13','1','da-hoan-thanh','1,4,7,27','103','89','2017-08-23 00:00:08'],['City Hunter 91','/images/2000/thumb/City_Hunter_91.jpg','Thợ Săn Thành Phố 91','1991','xuan','13','1','da-hoan-thanh','1,4,7,27','103','89','2017-08-23 00:00:09'],['Crayon Shin-chan','/images/2000/thumb/Crayon_Shin-chan.jpg','Shin Chan, Cậu Bé Bút Chì','1992','xuan','','1','con-tiep-tuc','36,4,15,9,23,42','93','','2017-08-23 00:00:10'],['Bishoujo Senshi Sailor Moon','/images/2000/thumb/Bishoujo_Senshi_Sailor_Moon.jpg','Thủy Thủ Mặt Trăng','1992','xuan','46','1','da-hoan-thanh','16,22,6,25','110','192','2017-08-23 00:00:11'],['Bishoujo Senshi Sailor Moon S','/images/2000/thumb/Bishoujo_Senshi_Sailor_Moon_S.jpg','Thủy Thủ Mặt Trăng S','1994','xuan','38','1','da-hoan-thanh','8,16,22,25','110','192','2017-08-23 00:00:12'],['Captain Tsubasa J','/images/2000/thumb/Captain_Tsubasa_J.jpg','Đội Trưởng Tsubasa J','1994','thu','47','1','da-hoan-thanh','1,27,30','97','191','2017-08-23 00:00:13'],['Mobile Suit Gundam Wing','/images/2000/thumb/Mobile_Suit_Gundam_Wing.jpg','','1995','xuan','49','1','da-hoan-thanh','1,38,24,29,8,18','103','7','2017-08-23 00:00:14'],['Bishoujo Senshi Sailor Moon SuperS','/images/2000/thumb/Bishoujo_Senshi_Sailor_Moon_SuperS.jpg','Thủy Thủ Mặt Trăng SuperS','1995','xuan','39','1','da-hoan-thanh','8,16,22,25','110','192','2017-08-23 00:00:15'],['Neon Genesis Evangelion','/images/2000/thumb/Neon_Genesis_Evangelion.jpg','','1995','thu','26','1','da-hoan-thanh','1,24,5,40,8,18','41105','3','2017-08-23 00:00:16'],['Dragon Ball GT','/images/2000/thumb/Dragon_Ball_GT.jpg','Bảy Viên Ngọc Rồng GT','1996','dong','64','1','da-hoan-thanh','1,2,4,10,16,24,27,31','110','2','2017-08-23 00:00:17'],['Rurouni Kenshin: Meiji Kenkaku Romantan','/images/2000/thumb/Rurouni_Kenshin__Meiji_Kenkaku_Romantan.jpg','Samurai X','1996','dong','94','1','da-hoan-thanh','1,2,4,13,22,21','99,98','6','2017-08-23 00:00:18'],['Detective Conan','/images/2000/thumb/Detective_Conan.jpg','Case Closed, Thám Tử Lừng Danh Conan','1996','dong','','1','con-tiep-tuc','2,4,7,39,27','108','5','2017-08-23 00:00:19'],['Bishoujo Senshi Sailor Moon: Sailor Stars','/images/2000/thumb/Bishoujo_Senshi_Sailor_Moon__Sailor_Stars.jpg','Thủy Thủ Mặt Trăng Stars','1996','dong','34','1','da-hoan-thanh','2,4,8,10,16,22,25','110','192','2017-08-23 00:00:20'],['Hana yori Dango','/images/2000/thumb/Hana_yori_Dango.jpg','Boys Over Flowers','1996','thu','51','1','da-hoan-thanh','8,22,23,25','110','','2017-08-23 00:00:21'],['Pokemon','/images/2000/thumb/Pokemon.jpg','Pocket Monsters, Bảo Bối Thần Kỳ','1997','xuan','276','1','da-hoan-thanh','1,2,4,15,10','72','8','2017-08-23 00:00:22'],['Kenpuu Denki Berserk','/images/2000/thumb/Kenpuu_Denki_Berserk.jpg','Sword-Wind Chronicle Berserk','1997','thu','25','1','da-hoan-thanh','1,2,6,8,10,14,38,22,42,37','72','32','2017-08-23 00:00:23'],['Dr. Slump','/images/2000/thumb/Dr_Slump.jpg','Doctor Slump','1997','thu','74','1','da-hoan-thanh','36,4,24,27','110','','2017-08-23 00:00:24'],['Cowboy Bebop','/images/2000/thumb/Cowboy_Bebop.jpg','','1998','xuan','26','1','da-hoan-thanh','1,2,4,8,24,29','103','187','2017-08-23 00:00:25'],['Trigun','/images/2000/thumb/Trigun.jpg','','1998','xuan','26','1','da-hoan-thanh','1,4,24','62','190','2017-08-23 00:00:26'],['Cardcaptor Sakura','/images/2000/thumb/Cardcaptor_Sakura.jpg','Card Captor Sakura, Thủ Lĩnh Thẻ Bài','1998','xuan','70','1','da-hoan-thanh','2,4,8,16,22,10,23,25','62','10','2017-08-23 00:00:27'],['Yu-Gi-Oh! ','/images/2000/thumb/Yu%E2%98%86Gi%E2%98%86Oh.jpg','King of Games, Vua Trò Chơi','1998','xuan','27','1','da-hoan-thanh','1,11,4,10,27','110','16','2017-08-23 00:00:28'],['Serial Experiments Lain','/images/2000/thumb/Serial_Experiments_Lain.jpg','','1998','ha','13','1','da-hoan-thanh','5,8,7,40,24,37','112','','2017-08-23 00:00:29'],['Great Teacher Onizuka','/images/2000/thumb/Great_Teacher_Onizuka.jpg','Thầy Giáo Vĩ Đại, GTO','1999','ha','43','1','da-hoan-thanh','4,8,23,27,36','102','','2017-08-23 00:00:30'],['One Piece','/images/2000/thumb/One_Piece.jpg','Vua Hải Tặc','1999','thu','','1','con-tiep-tuc','1,2,4,8,10,27,31','110','11','2017-08-23 00:00:31'],['Hunter x Hunter','/images/2000/thumb/Hunter_x_Hunter.jpg','','1999','thu','62','1','da-hoan-thanh','1,2,27,31','68','30','2017-08-23 00:00:32']];
        // ova
        dd($array);
        foreach($array as $key => $value) {
            $dirname = pathinfo($value[1], PATHINFO_DIRNAME);
            $basename = pathinfo($value[1], PATHINFO_BASENAME);
            $basename = CommonMethod::changeFileNameImage($basename, 1);
            $image = $dirname . '/' . $basename;

            $slug = CommonMethod::buildSlug($value[0]);
            $checkSlug = Post::where('slug', $slug)->first();
            if(isset($checkSlug)) {
                $slug .= '-' . $value[3];
            }

            $genres = explode(',', $value[8]);
            $tags = explode(',', $value[9]);
            $kind = $value[7];
            if($kind == SLUG_POST_KIND_FULL) {
                $episode = $value[5] . '/' . $value[5];
            } else {
                $episode = '1/???';
            }

            $data = Post::create([
                'name' => $value[0],
                'slug' => $slug,
                'name2' => $value[2],
                'type_main_id' => $genres[0],
                'seri' => $value[10],
                'type' => $value[6],
                'kind' => $kind,
                'year' => $value[3],
                'season' => $value[4],
                'episode' => $episode,
                'image' => $image,
                'start_date' => $value[11],
            ]);
            if(isset($data)) {
                // insert post type relation
                $data->posttypes()->attach($genres);
                // insert post tag relation
                $data->posttags()->attach($tags);
            }
        }
        dd('ok!');
    }

    private function getimageswithdir($dir = 'images/', $status = INACTIVE)
    {
        $lists = self::get_filelist_as_array($dir);
        // thay the dau \ thanh dau /
        $lists = str_replace('\\', '/', $lists);
        foreach($lists as $key => $value) {
            // sua duong dan anh
            $lists[$key] = '/'.$dir.$value;
            if($status == INACTIVE) {
                // xoa bo value co chua /thumb/ (khong watermark thumbnail)
                if((strpos($lists[$key], '/thumb/') !== false) || (strpos($lists[$key], '/thumb2/') !== false) || (strpos($lists[$key], '/thumb3/') !== false)) {
                    unset($lists[$key]);
                }
            }
        }
        return $lists;
    }

    // list all files as array
    private function get_filelist_as_array($dir = 'images/', $recursive = true, $basedir = '')
    {
        if ($dir == '') {return array();} else {$results = array(); $subresults = array();}
        if (!is_dir($dir)) {$dir = dirname($dir);} // so a files path can be sent
        if ($basedir == '') {$basedir = realpath($dir).DIRECTORY_SEPARATOR;}

        $files = scandir($dir);
        foreach ($files as $key => $value){
            if ( ($value != '.') && ($value != '..') ) {
                $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
                if (is_dir($path)) { // do not combine with the next line or..
                    if ($recursive) { // ..non-recursive list will include subdirs
                        $subdirresults = self::get_filelist_as_array($path,$recursive,$basedir);
                        $results = array_merge($results,$subdirresults);
                    }
                } else { // strip basedir and add to subarray to separate file list
                    $subresults[] = str_replace($basedir,'',$path);
                }
            }
        }
        // merge the subarray to give the list of files then subdirectory files
        if (count($subresults) > 0) {$results = array_merge($subresults,$results);}
        return $results;
    }

}