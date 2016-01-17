<?php namespace Vionox\News\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Cartalyst\Support\Traits\NamespacedEntityTrait;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class NewsPost extends Model implements EntityInterface, TaggableInterface {

	use EntityTrait, NamespacedEntityTrait, TaggableTrait;

	/**
	 * {@inheritDoc}
	 */
	protected $table = 'newsposts';

	/**
	 * {@inheritDoc}
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $with = [
		'values.attribute',
	];

	/**
	 * {@inheritDoc}
	 */
	protected static $entityNamespace = 'vionox/news.newspost';

}
