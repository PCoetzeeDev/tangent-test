<?php namespace App\Base\ValueObjects;

use App\Base\BaseEntity;
use Illuminate\Database\Eloquent\Collection;


abstract class ValueObject extends BaseEntity implements IValueObjectInterface
{
    const ORDER_BY_ORDER = 'order';

    protected $fillable = [
        'name',
        'slug',
        'order',
    ];

    /**
     * @param int $id
     * @return IValueObjectInterface
     */
	public static function getById(int $id) : IValueObjectInterface
    {
        return static::query()
            ->where('id', '=', $id)
            ->limit(1)
            ->get()
            ->first() ?? new static();
    }

    /**
     * @param string $slug
     * @return IValueObjectInterface
     */
	public static function getBySlug (string $slug) : IValueObjectInterface
	{
	    return static::query()
            ->where('slug', '=', $slug)
            ->limit(1)
            ->get()
            ->first() ?? new static();
	}

    /**
     * @param array $slugs
     * @param string $orderBy
     * @return Collection
     */
	public static function getBySlugs (array $slugs, string $orderBy = self::ORDER_BY_ORDER) : Collection
    {
	    return static::query()
            ->whereIn('slug', $slugs)
            ->orderBy($orderBy)
            ->get();
	}

    /**
     * @param string $name
     * @return IValueObjectInterface
     */
	public static function getByName (string $name) : IValueObjectInterface
	{
		return static::query()
            ->where('name', '=', $name)
            ->limit(1)
            ->get()
            ->first() ?? new static();
	}

    /**
     * @return int
     * @throws ValueObjectMissingDataException
     */
	public function getId (): int
    {
	    return $this->id ?? throw new ValueObjectMissingDataException();
	}

    /**
     * @return string
     * @throws ValueObjectMissingDataException
     */
	public function getSlug (): string
    {
	    return $this->slug ?? throw new ValueObjectMissingDataException();
	}

    /**
     * @return string
     * @throws ValueObjectMissingDataException
     */
    public function getName (): string
    {
	    return $this->name ?? throw new ValueObjectMissingDataException();
    }

    /**
     * @return int
     */
    public function getOrder (): int
    {
        return (isset($this->order)) ? $this->order : 1;
    }

    /**
     * @param $slug
     * @return bool
     * @throws ValueObjectMissingDataException
     */
    public function matchSlug ($slug): bool
    {
        return ($this->getSlug() === $slug);
    }

    /**
     * @param IValueObjectInterface $valueObject
     * @return bool
     * @throws ValueObjectMissingDataException
     */
    public function sameAs (IValueObjectInterface $valueObject): bool
    {
        return ($this->getSlug() === $valueObject->getSlug());
    }

    /**
     * @param Collection $valueObjects
     * @return bool
     * @throws ValueObjectMissingDataException
     */
    public function sameAsAny (Collection $valueObjects) : bool
    {
        foreach ($valueObjects as $valueObject) {
            if ($this->sameAs($valueObject)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getForFormSelectBySlug() : array
    {
	    return self::query()->where('is_active', '=', true)->orderBy('order')->pluck('name', 'slug')->toArray();
    }

    /**
     * @return string
     * @throws ValueObjectMissingDataException
     */
    public function __toString() : string
    {
        return $this->getName();
    }
}
