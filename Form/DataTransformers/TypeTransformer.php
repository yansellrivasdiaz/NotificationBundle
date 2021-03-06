<?php
/**
 * Created by PhpStorm.
 * User: ealcantara
 * Date: 3/6/2018
 * Time: 1:58 PM
 */

namespace NTI\NotificationBundle\Form\DataTransformers;


use Doctrine\Common\Persistence\ObjectManager;
use NTI\NotificationBundle\Entity\Type;
use Symfony\Component\Form\DataTransformerInterface;

class TypeTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (Type) to a string (number).
     *
     * @param  Type|null $object
     * @return string
     */
    public function transform($object)
    {
        if (null === $object) {
            return '';
        }
        return $object->getId();
    }

    /**
     * Transforms a string (number) to an object (Plant).
     *
     * @param  array $data
     * @return Type|null
     */
    public function reverseTransform($data)
    {
        # -- no data
        if (!$data) return null;

        $validKeys = array('id', 'code');
        $params = array();
        $isValid = false;

        if (is_array($data)){
            foreach ($validKeys as $validKey){
                if (array_key_exists($validKey, $data) && !array_key_exists($validKey, $params)){
                    $params[$validKey] = $data[$validKey];
                    $isValid = true;
                }
            }
        }

        # -- none of the accepted parameters given
        if ($isValid == false) return null;

        $object = $this->manager->getRepository('NotificationBundle:Type')->findOneBy($params);
        return $object;
    }

}