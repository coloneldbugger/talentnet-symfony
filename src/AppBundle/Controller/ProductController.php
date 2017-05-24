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

class ProductController extends FOSRestController
{
	/**
	 * @Rest\Get("/product")
	 */
	public function getAction()
	{
		$restresult = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
		if ($restresult === null) {
			return new View("no products exist", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}
	
	/**
	 * @Rest\Get("/product/{id}")
	 */
	public function idAction($id)
	{
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if ($singleresult === null) {
			return new View("product id not found", Response::HTTP_NOT_FOUND);
		}
		return $singleresult;
	}
	
	/**
	 * @Rest\Get("/product/sku/{sku}")
	 */
	public function skuAction($sku)
	{
		$sku = strtoupper($sku);
		$singleresult = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneBy(array('sku'=>$sku));
		if ($singleresult === null) {
			return new View("product sku not found", Response::HTTP_NOT_FOUND);
		}
		return $singleresult;
	}
	
	/**
	 * @Rest\Post("/product")
	 */
	public function postAction(Request $request)
	{
		$data = new Product;
		$name = $request->get('name');
		$sku = strtoupper($request->get('sku'));
		$category = $request->get('category');
		$quantity = $request->get('quantity');
		$price = $request->get('price');
		
		if(empty($name) || empty($category) || empty($sku) || empty($quantity) || empty($price))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}
		$data->setName($name);
		$data->setSku($sku);
		$data->setCategory($category);
		$data->setQuantity($quantity);
		$data->setPrice($price);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();
		return new View("Product Added Successfully", Response::HTTP_OK);
	}
	
	/**
	 * @Rest\Put("/product/{id}")
	 */
	public function updateAction($id,Request $request)
	{
		$data = new Product;
		$name = $request->get('name');
		$sku = strtoupper($request->get('sku'));
		$category = $request->get('category');
		$quantity = $request->get('quantity');
		$price = $request->get('price');
		$sn = $this->getDoctrine()->getManager();
		$product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if (empty($product)) {
			return new View("product not found", Response::HTTP_NOT_FOUND);
		}
		elseif(!empty($sku) || !empty($name) || !empty($category) || !empty($quantity) || !empty($price)){
			$returnString = "";
			if(!empty($sku)){
				$product->setSku($sku);
				$returnString .= "Sku, ";
			}
			if(!empty($name)){
				$product->setName($name);
				$returnString .= "Name, ";	
			}
			if(!empty($category)){
				$product->setCategory($category);
				$returnString .= "Category, ";
			}
			if(!empty($quantity)){
				$product->setQuantity($quantity);
				$returnString .= "Quantity, ";
			}
			if(!empty($price)){
				$product->setPrice($price);
				$returnString .= "Price, ";
			}
			$sn->flush();
			$returnString = rtrim($returnString, ', ') + " Updated Successfully";
			return new View($returnString, Response::HTTP_OK);
		}
		else return new View("Nothing updated", Response::HTTP_NOT_ACCEPTABLE);
	}
	
	/**
	 * @Rest\Delete("/product/{id}")
	 */
	public function deleteAction($id)
	{
		$data = new Product;
		$sn = $this->getDoctrine()->getManager();
		$product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if (empty($product)) {
			return new View("product not found", Response::HTTP_NOT_FOUND);
		}
		else {
			$sn->remove($product);
			$sn->flush();
		}
		return new View("deleted successfully", Response::HTTP_OK);
	}
}