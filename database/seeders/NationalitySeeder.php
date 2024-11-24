<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nationals = [

            [
                'name_en'=> 'Afghan',
                'name_ar'=> 'أفغانستاني'
            ],
            [

                'name_en'=> 'Albanian',
                'name_ar'=> 'ألباني'
            ],
            [

                'name_en'=> 'Aland Islander',
                'name_ar'=> 'آلاندي'
            ],
            [

                'name_en'=> 'Algerian',
                'name_ar'=> 'جزائري'
            ],
            [

                'name_en'=> 'American Samoan',
                'name_ar'=> 'أمريكي سامواني'
            ],
            [

                'name_en'=> 'Andorran',
                'name_ar'=> 'أندوري'
            ],
            [

                'name_en'=> 'Angolan',
                'name_ar'=> 'أنقولي'
            ],
            [

                'name_en'=> 'Anguillan',
                'name_ar'=> 'أنغويلي'
            ],
            [

                'name_en'=> 'Antarctican',
                'name_ar'=> 'أنتاركتيكي'
            ],
            [

                'name_en'=> 'Antiguan',
                'name_ar'=> 'بربودي'
            ],
            [

                'name_en'=> 'Argentinian',
                'name_ar'=> 'أرجنتيني'
            ],
            [

                'name_en'=> 'Armenian',
                'name_ar'=> 'أرميني'
            ],
            [

                'name_en'=> 'Aruban',
                'name_ar'=> 'أوروبهيني'
            ],
            [

                'name_en'=> 'Australian',
                'name_ar'=> 'أسترالي'
            ],
            [

                'name_en'=> 'Austrian',
                'name_ar'=> 'نمساوي'
            ],
            [

                'name_en'=> 'Azerbaijani',
                'name_ar'=> 'أذربيجاني'
            ],
            [

                'name_en'=> 'Bahamian',
                'name_ar'=> 'باهاميسي'
            ],
            [

                'name_en'=> 'Bahraini',
                'name_ar'=> 'بحريني'
            ],
            [

                'name_en'=> 'Bangladeshi',
                'name_ar'=> 'بنغلاديشي'
            ],
            [

                'name_en'=> 'Barbadian',
                'name_ar'=> 'بربادوسي'
            ],
            [

                'name_en'=> 'Belarusian',
                'name_ar'=> 'روسي'
            ],
            [

                'name_en'=> 'Belgian',
                'name_ar'=> 'بلجيكي'
            ],
            [

                'name_en'=> 'Belizean',
                'name_ar'=> 'بيليزي'
            ],
            [

                'name_en'=> 'Beninese',
                'name_ar'=> 'بنيني'
            ],
            [

                'name_en'=> 'Saint Barthelmian',
                'name_ar'=> 'سان بارتيلمي'
            ],
            [

                'name_en'=> 'Bermudan',
                'name_ar'=> 'برمودي'
            ],
            [

                'name_en'=> 'Bhutanese',
                'name_ar'=> 'بوتاني'
            ],
            [

                'name_en'=> 'Bolivian',
                'name_ar'=> 'بوليفي'
            ],
            [

                'name_en'=> 'Bosnian / Herzegovinian',
                'name_ar'=> 'بوسني/هرسكي'
            ],
            [

                'name_en'=> 'Botswanan',
                'name_ar'=> 'بوتسواني'
            ],
            [

                'name_en'=> 'Bouvetian',
                'name_ar'=> 'بوفيهي'
            ],
            [

                'name_en'=> 'Brazilian',
                'name_ar'=> 'برازيلي'
            ],
            [

                'name_en'=> 'British Indian Ocean Territory',
                'name_ar'=> 'إقليم المحيط الهندي البريطاني'
            ],
            [

                'name_en'=> 'Bruneian',
                'name_ar'=> 'بروني'
            ],
            [

                'name_en'=> 'Bulgarian',
                'name_ar'=> 'بلغاري'
            ],
            [

                'name_en'=> 'Burkinabe',
                'name_ar'=> 'بوركيني'
            ],
            [

                'name_en'=> 'Burundian',
                'name_ar'=> 'بورونيدي'
            ],
            [

                'name_en'=> 'Cambodian',
                'name_ar'=> 'كمبودي'
            ],
            [

                'name_en'=> 'Cameroonian',
                'name_ar'=> 'كاميروني'
            ],
            [

                'name_en'=> 'Canadian',
                'name_ar'=> 'كندي'
            ],
            [

                'name_en'=> 'Cape Verdean',
                'name_ar'=> 'الرأس الأخضر'
            ],
            [

                'name_en'=> 'Caymanian',
                'name_ar'=> 'كايماني'
            ],
            [

                'name_en'=> 'Central African',
                'name_ar'=> 'أفريقي'
            ],
            [

                'name_en'=> 'Chadian',
                'name_ar'=> 'تشادي'
            ],
            [

                'name_en'=> 'Chilean',
                'name_ar'=> 'شيلي'
            ],
            [

                'name_en'=> 'Chinese',
                'name_ar'=> 'صيني'
            ],
            [

                'name_en'=> 'Christmas Islander',
                'name_ar'=> 'جزيرة عيد الميلاد'
            ],
            [

                'name_en'=> 'Cocos Islander',
                'name_ar'=> 'جزر كوكوس'
            ],
            [

                'name_en'=> 'Colombian',
                'name_ar'=> 'كولومبي'
            ],
            [

                'name_en'=> 'Comorian',
                'name_ar'=> 'جزر القمر'
            ],
            [

                'name_en'=> 'Congolese',
                'name_ar'=> 'كونغي'
            ],
            [

                'name_en'=> 'Cook Islander',
                'name_ar'=> 'جزر كوك'
            ],
            [

                'name_en'=> 'Costa Rican',
                'name_ar'=> 'كوستاريكي'
            ],
            [

                'name_en'=> 'Croatian',
                'name_ar'=> 'كوراتي'
            ],
            [

                'name_en'=> 'Cuban',
                'name_ar'=> 'كوبي'
            ],
            [

                'name_en'=> 'Cypriot',
                'name_ar'=> 'قبرصي'
            ],
            [

                'name_en'=> 'Curacian',
                'name_ar'=> 'كوراساوي'
            ],
            [

                'name_en'=> 'Czech',
                'name_ar'=> 'تشيكي'
            ],
            [

                'name_en'=> 'Danish',
                'name_ar'=> 'دنماركي'
            ],
            [

                'name_en'=> 'Djiboutian',
                'name_ar'=> 'جيبوتي'
            ],
            [

                'name_en'=> 'Dominican',
                'name_ar'=> 'دومينيكي'
            ],
            [

                'name_en'=> 'Dominican',
                'name_ar'=> 'دومينيكي'
            ],
            [

                'name_en'=> 'Ecuadorian',
                'name_ar'=> 'إكوادوري'
            ],
            [

                'name_en'=> 'Egyptian',
                'name_ar'=> 'مصري'
            ],
            [

                'name_en'=> 'Salvadoran',
                'name_ar'=> 'سلفادوري'
            ],
            [

                'name_en'=> 'Equatorial Guinean',
                'name_ar'=> 'غيني'
            ],
            [

                'name_en'=> 'Eritrean',
                'name_ar'=> 'إريتيري'
            ],
            [

                'name_en'=> 'Estonian',
                'name_ar'=> 'استوني'
            ],
            [

                'name_en'=> 'Ethiopian',
                'name_ar'=> 'أثيوبي'
            ],
            [

                'name_en'=> 'Falkland Islander',
                'name_ar'=> 'فوكلاندي'
            ],
            [

                'name_en'=> 'Faroese',
                'name_ar'=> 'جزر فارو'
            ],
            [

                'name_en'=> 'Fijian',
                'name_ar'=> 'فيجي'
            ],
            [

                'name_en'=> 'Finnish',
                'name_ar'=> 'فنلندي'
            ],
            [

                'name_en'=> 'French',
                'name_ar'=> 'فرنسي'
            ],
            [

                'name_en'=> 'French Guianese',
                'name_ar'=> 'غويانا الفرنسية'
            ],
            [

                'name_en'=> 'French Polynesian',
                'name_ar'=> 'بولينيزيي'
            ],
            [

                'name_en'=> 'French',
                'name_ar'=> 'أراض فرنسية جنوبية وأنتارتيكية'
            ],
            [

                'name_en'=> 'Gabonese',
                'name_ar'=> 'غابوني'
            ],
            [

                'name_en'=> 'Gambian',
                'name_ar'=> 'غامبي'
            ],
            [

                'name_en'=> 'Georgian',
                'name_ar'=> 'جيورجي'
            ],
            [

                'name_en'=> 'German',
                'name_ar'=> 'ألماني'
            ],
            [

                'name_en'=> 'Ghanaian',
                'name_ar'=> 'غاني'
            ],
            [

                'name_en'=> 'Gibraltar',
                'name_ar'=> 'جبل طارق'
            ],
            [

                'name_en'=> 'Guernsian',
                'name_ar'=> 'غيرنزي'
            ],
            [

                'name_en'=> 'Greek',
                'name_ar'=> 'يوناني'
            ],
            [

                'name_en'=> 'Greenlandic',
                'name_ar'=> 'جرينلاندي'
            ],
            [

                'name_en'=> 'Grenadian',
                'name_ar'=> 'غرينادي'
            ],
            [

                'name_en'=> 'Guadeloupe',
                'name_ar'=> 'جزر جوادلوب'
            ],
            [

                'name_en'=> 'Guamanian',
                'name_ar'=> 'جوامي'
            ],
            [

                'name_en'=> 'Guatemalan',
                'name_ar'=> 'غواتيمالي'
            ],
            [

                'name_en'=> 'Guinean',
                'name_ar'=> 'غيني'
            ],
            [

                'name_en'=> 'Guinea-Bissauan',
                'name_ar'=> 'غيني'
            ],
            [

                'name_en'=> 'Guyanese',
                'name_ar'=> 'غياني'
            ],
            [

                'name_en'=> 'Haitian',
                'name_ar'=> 'هايتي'
            ],
            [

                'name_en'=> 'Heard and Mc Donald Islanders',
                'name_ar'=> 'جزيرة هيرد وجزر ماكدونالد'
            ],
            [

                'name_en'=> 'Honduran',
                'name_ar'=> 'هندوراسي'
            ],
            [

                'name_en'=> 'Hongkongese',
                'name_ar'=> 'هونغ كونغي'
            ],
            [

                'name_en'=> 'Hungarian',
                'name_ar'=> 'مجري'
            ],
            [

                'name_en'=> 'Icelandic',
                'name_ar'=> 'آيسلندي'
            ],
            [

                'name_en'=> 'Indian',
                'name_ar'=> 'هندي'
            ],
            [

                'name_en'=> 'Manx',
                'name_ar'=> 'ماني'
            ],
            [

                'name_en'=> 'Indonesian',
                'name_ar'=> 'أندونيسيي'
            ],
            [

                'name_en'=> 'Iranian',
                'name_ar'=> 'إيراني'
            ],
            [

                'name_en'=> 'Iraqi',
                'name_ar'=> 'عراقي'
            ],
            [

                'name_en'=> 'Irish',
                'name_ar'=> 'إيرلندي'
            ],
            [

                'name_en'=> 'Italian',
                'name_ar'=> 'إيطالي'
            ],
            [

                'name_en'=> 'Ivory Coastian',
                'name_ar'=> 'ساحل العاج'
            ],
            [

                'name_en'=> 'Jersian',
                'name_ar'=> 'جيرزي'
            ],
            [

                'name_en'=> 'Jamaican',
                'name_ar'=> 'جمايكي'
            ],
            [

                'name_en'=> 'Japanese',
                'name_ar'=> 'ياباني'
            ],
            [

                'name_en'=> 'Jordanian',
                'name_ar'=> 'أردني'
            ],
            [

                'name_en'=> 'Kazakh',
                'name_ar'=> 'كازاخستاني'
            ],
            [

                'name_en'=> 'Kenyan',
                'name_ar'=> 'كيني'
            ],
            [

                'name_en'=> 'I-Kiribati',
                'name_ar'=> 'كيريباتي'
            ],
            [

                'name_en'=> 'North Korean',
                'name_ar'=> 'كوري'
            ],
            [

                'name_en'=> 'South Korean',
                'name_ar'=> 'كوري'
            ],
            [

                'name_en'=> 'Kosovar',
                'name_ar'=> 'كوسيفي'
            ],
            [

                'name_en'=> 'Kuwaiti',
                'name_ar'=> 'كويتي'
            ],
            [

                'name_en'=> 'Kyrgyzstani',
                'name_ar'=> 'قيرغيزستاني'
            ],
            [

                'name_en'=> 'Laotian',
                'name_ar'=> 'لاوسي'
            ],
            [

                'name_en'=> 'Latvian',
                'name_ar'=> 'لاتيفي'
            ],
            [

                'name_en'=> 'Lebanese',
                'name_ar'=> 'لبناني'
            ],
            [

                'name_en'=> 'Basotho',
                'name_ar'=> 'ليوسيتي'
            ],
            [

                'name_en'=> 'Liberian',
                'name_ar'=> 'ليبيري'
            ],
            [

                'name_en'=> 'Libyan',
                'name_ar'=> 'ليبي'
            ],
            [

                'name_en'=> 'Liechtenstein',
                'name_ar'=> 'ليختنشتيني'
            ],
            [

                'name_en'=> 'Lithuanian',
                'name_ar'=> 'لتوانيي'
            ],
            [

                'name_en'=> 'Luxembourger',
                'name_ar'=> 'لوكسمبورغي'
            ],
            [

                'name_en'=> 'Sri Lankian',
                'name_ar'=> 'سريلانكي'
            ],
            [

                'name_en'=> 'Macanese',
                'name_ar'=> 'ماكاوي'
            ],
            [

                'name_en'=> 'Macedonian',
                'name_ar'=> 'مقدوني'
            ],
            [

                'name_en'=> 'Malagasy',
                'name_ar'=> 'مدغشقري'
            ],
            [

                'name_en'=> 'Malawian',
                'name_ar'=> 'مالاوي'
            ],
            [

                'name_en'=> 'Malaysian',
                'name_ar'=> 'ماليزي'
            ],
            [

                'name_en'=> 'Maldivian',
                'name_ar'=> 'مالديفي'
            ],
            [

                'name_en'=> 'Malian',
                'name_ar'=> 'مالي'
            ],
            [

                'name_en'=> 'Maltese',
                'name_ar'=> 'مالطي'
            ],
            [

                'name_en'=> 'Marshallese',
                'name_ar'=> 'مارشالي'
            ],
            [

                'name_en'=> 'Martiniquais',
                'name_ar'=> 'مارتينيكي'
            ],
            [

                'name_en'=> 'Mauritanian',
                'name_ar'=> 'موريتانيي'
            ],
            [

                'name_en'=> 'Mauritian',
                'name_ar'=> 'موريشيوسي'
            ],
            [

                'name_en'=> 'Mahoran',
                'name_ar'=> 'مايوتي'
            ],
            [

                'name_en'=> 'Mexican',
                'name_ar'=> 'مكسيكي'
            ],
            [

                'name_en'=> 'Micronesian',
                'name_ar'=> 'مايكرونيزيي'
            ],
            [

                'name_en'=> 'Moldovan',
                'name_ar'=> 'مولديفي'
            ],
            [

                'name_en'=> 'Monacan',
                'name_ar'=> 'مونيكي'
            ],
            [

                'name_en'=> 'Mongolian',
                'name_ar'=> 'منغولي'
            ],
            [

                'name_en'=> 'Montenegrin',
                'name_ar'=> 'الجبل الأسود'
            ],
            [

                'name_en'=> 'Montserratian',
                'name_ar'=> 'مونتسيراتي'
            ],
            [

                'name_en'=> 'Moroccan',
                'name_ar'=> 'مغربي'
            ],
            [

                'name_en'=> 'Mozambican',
                'name_ar'=> 'موزمبيقي'
            ],
            [

                'name_en'=> 'Myanmarian',
                'name_ar'=> 'ميانماري'
            ],
            [

                'name_en'=> 'Namibian',
                'name_ar'=> 'ناميبي'
            ],
            [

                'name_en'=> 'Nauruan',
                'name_ar'=> 'نوري'
            ],
            [

                'name_en'=> 'Nepalese',
                'name_ar'=> 'نيبالي'
            ],
            [

                'name_en'=> 'Dutch',
                'name_ar'=> 'هولندي'
            ],
            [

                'name_en'=> 'Dutch Antilier',
                'name_ar'=> 'هولندي'
            ],
            [

                'name_en'=> 'New Caledonian',
                'name_ar'=> 'كاليدوني'
            ],
            [

                'name_en'=> 'New Zealander',
                'name_ar'=> 'نيوزيلندي'
            ],
            [

                'name_en'=> 'Nicaraguan',
                'name_ar'=> 'نيكاراجوي'
            ],
            [

                'name_en'=> 'Nigerien',
                'name_ar'=> 'نيجيري'
            ],
            [

                'name_en'=> 'Nigerian',
                'name_ar'=> 'نيجيري'
            ],
            [

                'name_en'=> 'Niuean',
                'name_ar'=> 'ني'
            ],
            [

                'name_en'=> 'Norfolk Islander',
                'name_ar'=> 'نورفوليكي'
            ],
            [

                'name_en'=> 'Northern Marianan',
                'name_ar'=> 'ماريني'
            ],
            [

                'name_en'=> 'Norwegian',
                'name_ar'=> 'نرويجي'
            ],
            [

                'name_en'=> 'Omani',
                'name_ar'=> 'عماني'
            ],
            [

                'name_en'=> 'Pakistani',
                'name_ar'=> 'باكستاني'
            ],
            [

                'name_en'=> 'Palauan',
                'name_ar'=> 'بالاوي'
            ],
            [

                'name_en'=> 'Palestinian',
                'name_ar'=> 'فلسطيني'
            ],
            [

                'name_en'=> 'Panamanian',
                'name_ar'=> 'بنمي'
            ],
            [

                'name_en'=> 'Papua New Guinean',
                'name_ar'=> 'بابوي'
            ],
            [

                'name_en'=> 'Paraguayan',
                'name_ar'=> 'بارغاوي'
            ],
            [

                'name_en'=> 'Peruvian',
                'name_ar'=> 'بيري'
            ],
            [

                'name_en'=> 'Filipino',
                'name_ar'=> 'فلبيني'
            ],
            [

                'name_en'=> 'Pitcairn Islander',
                'name_ar'=> 'بيتكيرني'
            ],
            [

                'name_en'=> 'Polish',
                'name_ar'=> 'بوليني'
            ],
            [

                'name_en'=> 'Portuguese',
                'name_ar'=> 'برتغالي'
            ],
            [

                'name_en'=> 'Puerto Rican',
                'name_ar'=> 'بورتي'
            ],
            [

                'name_en'=> 'Qatari',
                'name_ar'=> 'قطري'
            ],
            [

                'name_en'=> 'Reunionese',
                'name_ar'=> 'ريونيوني'
            ],
            [

                'name_en'=> 'Romanian',
                'name_ar'=> 'روماني'
            ],
            [

                'name_en'=> 'Russian',
                'name_ar'=> 'روسي'
            ],
            [

                'name_en'=> 'Rwandan',
                'name_ar'=> 'رواندا'
            ],
            [

                'name_en'=> '',
                'name_ar'=> 'Kittitian/Nevisian'
            ],
            [

                'name_en'=> 'St. Martian(French)',
                'name_ar'=> 'ساينت مارتني فرنسي'
            ],
            [

                'name_en'=> 'St. Martian(Dutch)',
                'name_ar'=> 'ساينت مارتني هولندي'
            ],
            [

                'name_en'=> 'St. Pierre and Miquelon',
                'name_ar'=> 'سان بيير وميكلوني'
            ],
            [

                'name_en'=> 'Saint Vincent and the Grenadines',
                'name_ar'=> 'سانت فنسنت وجزر غرينادين'
            ],
            [

                'name_en'=> 'Samoan',
                'name_ar'=> 'ساموي'
            ],
            [

                'name_en'=> 'Sammarinese',
                'name_ar'=> 'ماريني'
            ],
            [

                'name_en'=> 'Sao Tomean',
                'name_ar'=> 'ساو تومي وبرينسيبي'
            ],
            [

                'name_en'=> 'Saudi Arabian',
                'name_ar'=> 'سعودي'
            ],
            [

                'name_en'=> 'Senegalese',
                'name_ar'=> 'سنغالي'
            ],
            [

                'name_en'=> 'Serbian',
                'name_ar'=> 'صربي'
            ],
            [

                'name_en'=> 'Seychellois',
                'name_ar'=> 'سيشيلي'
            ],
            [

                'name_en'=> 'Sierra Leonean',
                'name_ar'=> 'سيراليوني'
            ],
            [

                'name_en'=> 'Singaporean',
                'name_ar'=> 'سنغافوري'
            ],
            [

                'name_en'=> 'Slovak',
                'name_ar'=> 'سولفاكي'
            ],
            [

                'name_en'=> 'Slovenian',
                'name_ar'=> 'سولفيني'
            ],
            [

                'name_en'=> 'Solomon Island',
                'name_ar'=> 'جزر سليمان'
            ],
            [

                'name_en'=> 'Somali',
                'name_ar'=> 'صومالي'
            ],
            [

                'name_en'=> 'South African',
                'name_ar'=> 'أفريقي'
            ],
            [

                'name_en'=> 'South Georgia and the South Sandwich',
                'name_ar'=> 'لمنطقة القطبية الجنوبية'
            ],
            [

                'name_en'=> 'South Sudanese',
                'name_ar'=> 'سوادني جنوبي'
            ],
            [

                'name_en'=> 'Spanish',
                'name_ar'=> 'إسباني'
            ],
            [

                'name_en'=> 'St. Helenian',
                'name_ar'=> 'هيلاني'
            ],
            [

                'name_en'=> 'Sudanese',
                'name_ar'=> 'سوداني'
            ],
            [

                'name_en'=> 'Surinamese',
                'name_ar'=> 'سورينامي'
            ],
            [

                'name_en'=> 'Svalbardian/Jan Mayenian',
                'name_ar'=> 'سفالبارد ويان ماين'
            ],
            [

                'name_en'=> 'Swazi',
                'name_ar'=> 'سوازيلندي'
            ],
            [

                'name_en'=> 'Swedish',
                'name_ar'=> 'سويدي'
            ],
            [

                'name_en'=> 'Swiss',
                'name_ar'=> 'سويسري'
            ],
            [

                'name_en'=> 'Syrian',
                'name_ar'=> 'سوري'
            ],
            [

                'name_en'=> 'Taiwanese',
                'name_ar'=> 'تايواني'
            ],
            [

                'name_en'=> 'Tajikistani',
                'name_ar'=> 'طاجيكستاني'
            ],
            [

                'name_en'=> 'Tanzanian',
                'name_ar'=> 'تنزانيي'
            ],
            [

                'name_en'=> 'Thai',
                'name_ar'=> 'تايلندي'
            ],
            [

                'name_en'=> 'Timor-Lestian',
                'name_ar'=> 'تيموري'
            ],
            [

                'name_en'=> 'Togolese',
                'name_ar'=> 'توغي'
            ],
            [

                'name_en'=> 'Tokelaian',
                'name_ar'=> 'توكيلاوي'
            ],
            [

                'name_en'=> 'Tongan',
                'name_ar'=> 'تونغي'
            ],
            [

                'name_en'=> 'Trinidadian/Tobagonian',
                'name_ar'=> 'ترينيداد وتوباغو'
            ],
            [

                'name_en'=> 'Tunisian',
                'name_ar'=> 'تونسي'
            ],
            [

                'name_en'=> 'Turkish',
                'name_ar'=> 'تركي'
            ],
            [

                'name_en'=> 'Turkmen',
                'name_ar'=> 'تركمانستاني'
            ],
            [

                'name_en'=> 'Turks and Caicos Islands',
                'name_ar'=> 'جزر توركس وكايكوس'
            ],
            [

                'name_en'=> 'Tuvaluan',
                'name_ar'=> 'توفالي'
            ],
            [

                'name_en'=> 'Ugandan',
                'name_ar'=> 'أوغندي'
            ],
            [

                'name_en'=> 'Ukrainian',
                'name_ar'=> 'أوكراني'
            ],
            [

                'name_en'=> 'Emirati',
                'name_ar'=> 'إماراتي'
            ],
            [

                'name_en'=> 'British',
                'name_ar'=> 'بريطاني'
            ],
            [

                'name_en'=> 'American',
                'name_ar'=> 'أمريكي'
            ],
            [

                'name_en'=> 'US Minor Outlying Islander',
                'name_ar'=> 'أمريكي'
            ],
            [

                'name_en'=> 'Uruguayan',
                'name_ar'=> 'أورغواي'
            ],
            [

                'name_en'=> 'Uzbek',
                'name_ar'=> 'أوزباكستاني'
            ],
            [

                'name_en'=> 'Vanuatuan',
                'name_ar'=> 'فانواتي'
            ],
            [

                'name_en'=> 'Venezuelan',
                'name_ar'=> 'فنزويلي'
            ],
            [

                'name_en'=> 'Vietnamese',
                'name_ar'=> 'فيتنامي'
            ],
            [

                'name_en'=> 'American Virgin Islander',
                'name_ar'=> 'أمريكي'
            ],
            [

                'name_en'=> 'Vatican',
                'name_ar'=> 'فاتيكاني'
            ],
            [

                'name_en'=> 'Wallisian/Futunan',
                'name_ar'=> 'فوتوني'
            ],
            [

                'name_en'=> 'Sahrawian',
                'name_ar'=> 'صحراوي'
            ],
            [

                'name_en'=> 'Yemeni',
                'name_ar'=> 'يمني'
            ],
            [

                'name_en'=> 'Zambian',
                'name_ar'=> 'زامبياني'
            ],
            [

                'name_en'=> 'Zimbabwean',
                'name_ar'=> 'زمبابوي'
            ]
        ];

        foreach ($nationals as $nationality) {
            Nationality::create([
                'name_ar' => $nationality['name_ar'],
                'name_en' => $nationality['name_en'],
            ]);
        }
    }
}
