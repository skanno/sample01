<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Utility\Text;

class ArticlesTable extends Table
{
    /**
     * Undocumented function
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
    }

    /**
     * Undocumented function
     *
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\ORM\Entity $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function beforeSave(EventInterface $event, Entity $entity, ArrayObject $options): void
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
}
