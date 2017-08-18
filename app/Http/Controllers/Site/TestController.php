<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Models\Post;

use Sunra\PhpSimple\HtmlDomParser;

class TestController extends Controller
{
    public function index()
    {
        dd('no permission');

        return view('site.test');
        
        // $array1 = [
        //     'Xebec',
        //     'Studio Gallop'
        // ];
        // $array = [
        //     '1' => '3xCube',
        //     '2' => '8bit',
        //     '3' => 'A.C.G.T.',
        //     '4' => 'A-1 Pictures',
        //     '5' => 'Actas',
        //     '6' => 'AIC',
        //     '7' => 'AIC A.S.T.A.',
        //     '8' => 'AIC Build',
        //     '9' => 'AIC Classic',
        //     '10' => 'AIC Plus+',
        //     '11' => 'AIC Spirits',
        //     '12' => 'Ajia-Do',
        //     '13' => 'Arms',
        //     '14' => 'Artland',
        //     '15' => 'Asahi Production',
        //     '16' => 'Asread',
        //     '17' => 'AXsiZ',
        //     '18' => 'Bandai Namco Pictures',
        //     '19' => 'Barnum Studio',
        //     '20' => 'Bee Media',
        //     '21' => 'Bee Train',
        //     '22' => 'Bones',
        //     '23' => 'Brain\'s Base',
        //     '24' => 'Bridge',
        //     '25' => 'C2C',
        //     '26' => 'CoMix Wave Films',
        //     '27' => 'Connect',
        //     '28' => 'Creators in Pack',
        //     '29' => 'C-Station',
        //     '30' => 'Daume',
        //     '31' => 'David Production',
        //     '32' => 'Diomedea',
        //     '33' => 'DMM.futureworks',
        //     '34' => 'Doga Kobo',
        //     '35' => 'Egg Firm',
        //     '36' => 'EMT²',
        //     '37' => 'Encourage Films',
        //     '38' => 'Fanworks',
        //     '39' => 'feel.',
        //     '40' => 'Fuji TV',
        //     '41' => 'Gainax',
        //     '42' => 'GEMBA',
        //     '43' => 'GoHands',
        //     '44' => 'Gonzo',
        //     '45' => 'Graphinica',
        //     '46' => 'Group TAC',
        //     '47' => 'Hal Film Maker',
        //     '48' => 'Haoliners Animation League',
        //     '49' => 'Hoods Drifters Studio',
        //     '50' => 'Hoods Entertainment',
        //     '51' => 'ILCA',
        //     '52' => 'Imagin',
        //     '53' => 'Will Palette',
        //     '54' => 'J.C.Staff',
        //     '55' => 'Kinema Citrus',
        //     '56' => 'KOO-KI',
        //     '57' => 'Kyoto Animation',
        //     '58' => 'Lay-duce',
        //     '59' => 'Lerche',
        //     '60' => 'LIDENFILMS',
        //     '61' => 'M2',
        //     '62' => 'Madhouse',
        //     '63' => 'Manglobe',
        //     '64' => 'MAPPA',
        //     '65' => 'Namu Animation',
        //     '66' => 'NAZ',
        //     '67' => 'Nexus',
        //     '68' => 'Nippon Animation',
        //     '69' => 'Nomad',
        //     '70' => 'NUT',
        //     '71' => 'Office DCI',
        //     '72' => 'OLM',
        //     '73' => 'Orange',
        //     '74' => 'Ordet',
        //     '75' => 'P.A. Works',
        //     '76' => 'Palm Studio',
        //     '77' => 'Passione',
        //     '78' => 'Pierrot Plus',
        //     '79' => 'Pine Jam',
        //     '80' => 'Platinum Vision',
        //     '81' => 'Polygon Pictures',
        //     '82' => 'Production I.G',
        //     '83' => 'Production IMS',
        //     '84' => 'Production Reed',
        //     '85' => 'Project No.9',
        //     '86' => 'Radix',
        //     '87' => 'SANZIGEN',
        //     '88' => 'Satelight',
        //     '89' => 'Seven',
        //     '90' => 'Seven Arcs',
        //     '91' => 'Seven Arcs Pictures',
        //     '92' => 'Shaft',
        //     '93' => 'Shin-Ei Animation',
        //     '94' => 'Shuka',
        //     '95' => 'Silver Link.',
        //     '96' => 'Studio 3Hz',
        //     '97' => 'Studio Comet',
        //     '98' => 'Studio Deen',
        //     '99' => 'Studio Gallop',
        //     '100' => 'Studio Gokumi',
        //     '101' => 'Studio Hibari',
        //     '102' => 'Studio Pierrot',
        //     '103' => 'Sunrise',
        //     '104' => 'SynergySP',
        //     '105' => 'Tatsunoko Production',
        //     '106' => 'Telecom Animation Film',
        //     '107' => 'Tezuka Productions',
        //     '108' => 'TMS Entertainment',
        //     '109' => 'TNK',
        //     '110' => 'Toei Animation',
        //     '111' => 'Trans Arts',
        //     '112' => 'Triangle Staff',
        //     '113' => 'Trigger',
        //     '114' => 'TROYCA',
        //     '115' => 'Tsuchida Productions',
        //     '116' => 'TYO Animations',
        //     '117' => 'TYPHOON GRAPHICS',
        //     '118' => 'ufotable',
        //     '119' => 'White Fox',
        //     '120' => 'Wit Studio',
        //     '121' => 'Xebec',
        //     '122' => 'Yaoyorozu',
        //     '123' => 'Zero-G',
        //     '124' => 'Zexcs',
        //     '125' => 'BeSTACK',
        //     '126' => 'Remic',
        //     '127' => 'Studio Blanc',
        //     '128' => 'Marvy Jack',
        //     '129' => 'W-Toon Studio',
        //     '130' => 'Shirogumi',
        //     '131' => 'Millepensee',
        //     '132' => 'Picture Magic',
        //     '133' => 'Studio Ghibli',
        //     '134' => 'Signal. MD',
        //     '135' => 'Studio VOLN',
        //     '136' => 'M.S.C',
        //     '137' => 'ixtl',
        //     '138' => 'Studio Ponoc',
        //     '139' => 'Marza Animation Planet',
        //     '140' => 'Science SARU',
        //     '141' => 'JUMONJI',
        //     '142' => 'Qualia Animation',
        //     '143' => 'Digital Frontier',
        //     '144' => 'Square Enix',
        //     '145' => 'Digic Pictures',
        //     '146' => 'B&T',
        //     '147' => 'Studio 4°C',
        //     '148' => 'Studio Chizu',
        //     '149' => 'Sola Digital Arts',
        //     '150' => 'Studio Rikka',
        //     '151' => 'Studio Colorido',
        //     '152' => 'Rockwell Eyes',
        //     '153' => 'Steve N\' Steven',
        //     '154' => 'Geno Studio',
        //     '155' => 'Purple Cow Studio Japan',
        //     '156' => 'Yamato Works',
        //     '157' => 'Ascension',
        //     '158' => 'Tokyo Movie Shinsha',
        //     '159' => 'Khara',
        //     '160' => 'Think Corporation',
        //     '161' => 'Oh! Production',
        //     '162' => 'The Answer Studio',
        //     '163' => 'APPP',
        //     '164' => 'LandQ studios',
        //     '165' => 'Arcs Create',
        //     '166' => 'Shinkuukan',
        //     '167' => 'Chaos Project',
        // '168' => 'Studio Fantasia',
        // '169' => 'Gathering',
        // '170' => 'Anpro',
        // '171' => 'Studio Animal',
        // '172' => 'Kamikaze Douga',
        // '173' => 'Studio PuYUKAI',
        // '174' => 'An DerCen',
        // '175' => 'Felix Film',


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

}