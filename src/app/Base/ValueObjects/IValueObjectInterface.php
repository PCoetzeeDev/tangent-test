<?php namespace App\Base\ValueObjects;

use Illuminate\Database\Eloquent\Collection;

interface IValueObjectInterface
{
    /**
     * @param int $id
     * @return self
     */
    public static function getById (int $id) : self;

    /**
     * @param string $slug
     * @return self
     */
    public static function getBySlug (string $slug) : self;

    /**
     * @param array $slugs
     * @param string $orderBy
     * @return Collection
     */
    public static function getBySlugs (array $slugs, string $orderBy) : Collection;

    /**
     * @param string $name
     * @return self
     */
    public static function getByName (string $name) : self;

    /**
     * @return int
     */
    public function getId () : int;

    /**
     * @return string
     */
    public function getSlug () : string;

    /**
     * @return string
     */
    public function getName () : string;

    /**
     * @return int
     */
    public function getOrder () : int;

    /**
     * @param string $slug
     * @return bool
     */
    public function matchSlug (string $slug) : bool;

    /**
     * @param IValueObjectInterface $valueObject
     * @return bool
     */
    public function sameAs (IValueObjectInterface $valueObject) : bool;

    /**
     * @param Collection $valueObjects
     * @return bool
     */
    public function sameAsAny (Collection $valueObjects) : bool;

    /**
     * @return array
     */
    public static function getForFormSelectBySlug() : array;
}
