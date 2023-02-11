<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Helpers\Helpers;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Cache;

class CategorieCrawler extends Command
{
    private $catetories = [];
    private $i = 0;
    private $x = 0;

    private $y = 0;
    private $z = 0;

    public $url = 'https://sahibinden.com';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Categories Crawler';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @TODO: Cache temizleniyor!
         */
        Cache::forget('categories');

        $user_agent = Helpers::userAgent();

        $goutteClient = new Client(HttpClient::create(array(
            'headers' => [
                'User-Agent' => $user_agent,
                'Accept'     => 'text/html',
            ],
            'timeout' => 800,
        )));

        $crawler = $goutteClient->request('GET', $this->url);

        $top_categories = $crawler->filter('ul.categories-left-menu > li')->each(function ($node){
            $this->x = 0;
            try {
                $this->warn($node->filter('a')->first()->text());
                $this->catetories[$this->i] = [
                    'name' => $node->filter('a')->first()->text(),
                    'link' => $node->filter('a')->first()->attr('href'),
                    'slug' => str_replace('/kategori/', '',$node->filter('a')->first()->attr('href')),
                    'sub' => []
                ];

                $node->filter('ul > li')->each(function ($sub_node) {
                   $this->info('--' . $sub_node->filter('a')->first()->text());
                    $this->catetories[$this->i]['sub'][$this->x] = [
                        'name' => $sub_node->filter('a')->first()->text(),
                        'link' => $sub_node->filter('a')->first()->attr('href'),
                        'slug' => str_replace('/kategori/', '',$sub_node->filter('a')->first()->attr('href')),
                        'sub' => [],

                    ];

                    $this->x++;
                });

                $this->i++;

            } catch (\Exception $e) {

            }

        });

        $value = Cache::rememberForever('categories', function () {
            return $this->catetories;
        });

        //$this->retrieveSubCats();

    }

    private function retrieveSubCats() {
        if(Cache::has('categories')) {

            $this->warn('--------------------------------------');
            $this->warn('|                 ***                |');
            $this->warn('|          Alt Kategoriler           |');
            $this->warn('|                 ***                |');
            $this->warn('--------------------------------------');

            $categories = Cache::get('categories');
            foreach ($categories AS $main_key => $category) {
                $this->info('Kategori: '.$category['name']);
                $this->y = 0;

                foreach($category['sub'] AS $sub_key => $sub) {
                    $user_agent = Helpers::userAgent();

                    $goutteClient = new Client(HttpClient::create(array(
                        'headers' => [
                            'User-Agent' => $user_agent,
                            'Accept'     => 'text/html',
                        ],
                        'timeout' => 800,
                    )));

                    $crawler = $goutteClient->request('GET', 'https://www.sahibinden.com/alt-kategori/'.$sub['slug']);

                    try {
                        $top_categories = $crawler->filter('.allCategoriesList')->each(function ($node) use ($main_key, $sub_key){
                            $name = $node->filter('div a')->first()->text();
                            $link = $node->filter('div a')->first()->attr('href');
                            $slug = str_replace('/', '',$node->filter('a')->first()->attr('href'));

                            $this->catetories[$main_key]['sub'][$sub_key]['sub'][$this->y] = [
                                'name' => $name,
                                'link' => $link,
                                'slug' => $slug,
                                'sub' => [],

                            ];



                            $this->y++;

                        });
                    } catch (\Exception $e) {

                    }
                }dd($this->catetories);
            }



        } else {
            $this->warn('Kategori Yok');
        }
    }
}
