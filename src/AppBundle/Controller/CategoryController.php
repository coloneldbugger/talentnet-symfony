<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class CategoryController extends FOSRestController
{
	/**
	 * @Rest\Get("/category")
	 */
	public function getAction()
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
		if ($restresult === null) {
			return new View("no products exist", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}
	
}