<?php

namespace App\Filter;

use App\Annotation\FilterOn;
use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

class RestrictFilter extends SQLFilter
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function setReader(Reader $reader): void
    {
        $this->reader = $reader;
    }

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "user aware" (marked with an annotation)
        $filterOn = $this->reader->getClassAnnotation($targetEntity->getReflectionClass(), FilterOn::class);

        if (!$filterOn) {
            return '';
        }

        $fieldName = $filterOn->fieldName;
        $value = $filterOn->value;

        if (empty($fieldName)) {
            return '';
        }

        if (empty($value)) {
            $query = sprintf('%s.%s IS NOT NULL', $targetTableAlias, $fieldName);
        } else {
            $query = sprintf('%s.%s = %s', $targetTableAlias, $fieldName, $value);
        }



        return $query;
    }
}