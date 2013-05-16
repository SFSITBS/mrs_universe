<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show a list of blog unit_of_measure.
 * 
 * @author		PyroCMS Dev Team
 * @author		Stephen Cozart
 * @package 	PyroCMS\Core\Modules\Blog\Widgets
 */
class Widget_Blog_unit_of_measure extends Widgets
{

        public $title = array(
            'en'         => 'Blog unit_of_measure',
            'br'         => 'Categorias do Blog',
            'pt'         => 'Categorias do Blog',
            'el'         => 'Κατηγορίες Ιστολογίου',
            'fr'         => 'Catégories du Blog',
            'ru'         => 'Категории Блога',
            'id'         => 'Kateori Blog',
        );
        public $description = array(
            'en'     => 'Show a list of blog unit_of_measure',
            'br'     => 'Mostra uma lista de navegação com as categorias do Blog',
            'pt'     => 'Mostra uma lista de navegação com as categorias do Blog',
            'el'     => 'Προβάλει την λίστα των κατηγοριών του ιστολογίου σας',
            'fr'     => 'Permet d\'afficher la liste de Catégories du Blog',
            'ru'     => 'Выводит список категорий блога',
            'id'     => 'Menampilkan daftar kategori tulisan',
        );
        public $author  = 'Stephen Cozart';
        public $website = 'http://github.com/clip/';
        public $version = '1.0';

        public function run()
        {
                $this->load->model('blog/blog_unit_of_measure_m');

                $unit_of_measure = $this->blog_unit_of_measure_m->order_by('title')->get_all();

                return array('unit_of_measure' => $unit_of_measure);
        }

}
