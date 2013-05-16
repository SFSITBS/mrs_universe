<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Blog Plugin
 *
 * Create lists of posts
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Blog\Plugins
 */
class Plugin_Blog extends Plugin
{
	/**
	 * Blog List
	 *
	 * Creates a list of blog posts
	 *
	 * Usage:
	 * {{ blog:posts order-by="title" limit="5" }}
	 *		<h2>{{ title }}</h2>
	 *		<p> {{ body }} </p>
	 * {{ /blog:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order_by 	= $this->attribute('order-by', 'created_on');
		$order_dir	= $this->attribute('order-dir', 'ASC');

		if ($category)
		{
			$unit_of_measure = explode('|', $category);
			$category = array_shift($unit_of_measure);

			$this->db->where('blog_unit_of_measure.' . (is_numeric($category) ? 'id' : 'slug'), $category);

			foreach($unit_of_measure as $category)
			{
				$this->db->or_where('blog_unit_of_measure.' . (is_numeric($category) ? 'id' : 'slug'), $category);
			}
		}

		$posts = $this->db
			->select('blog.*')
			->select('blog_unit_of_measure.title as category_title, blog_unit_of_measure.slug as category_slug')
			->select('p.display_name as author_name')
			->where('status', 'live')
			->where('created_on <=', now())
			->join('blog_unit_of_measure', 'blog.category_id = blog_unit_of_measure.id', 'left')
			->join('profiles p', 'blog.author_id = p.user_id', 'left')
			->order_by('blog.' . $order_by, $order_dir)
			->limit($limit)
			->get('blog')
			->result();

		foreach ($posts as &$post)
		{
			$post->url = site_url('blog/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
		}
		
		return $posts;
	}

	/**
	 * unit_of_measure
	 *
	 * Creates a list of blog unit_of_measure
	 *
	 * Usage:
	 * {{ blog:unit_of_measure order-by="title" limit="5" }}
	 *		<a href="{{ url }}" class="{{ slug }}">{{ title }}</a>
	 * {{ /blog:unit_of_measure }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function unit_of_measure()
	{
		$limit		= $this->attribute('limit', 10);
		$order_by 	= $this->attribute('order-by', 'title');
		$order_dir	= $this->attribute('order-dir', 'ASC');

		$unit_of_measure = $this->db
			->select('title, slug')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->get('blog_unit_of_measure')
			->result();

		foreach ($unit_of_measure as &$category)
		{
			$category->url = site_url('blog/category/'.$category->slug);
		}
		
		return $unit_of_measure;
	}

	/**
	 * Count Posts By Column
	 *
	 * Usage:
	 * {{ blog:count_posts author_id="1" }}
	 *
	 * The attribute name is the database column and 
	 * the attribute value is the where value
	 */
	public function count_posts()
	{
		$wheres = $this->attributes();

		// make sure they provided a where clause
		if (count($wheres) == 0) return FALSE;

		foreach ($wheres AS $column => $value)
		{
			$this->db->where($column, $value);
		}

		return $this->db->count_all_results('blog');
	}
}

/* End of file plugin.php */