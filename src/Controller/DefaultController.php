<?php
/**
 * @author: Scott Williams
 */

namespace App\Controller;

use App\Entity\DeliveryDriver;
use App\Entity\DeliveryMethod;
use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\Pizza;
use App\Entity\PizzaIngredients;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $registryManager;

    public function __construct(ManagerRegistry $registryManager)
    {
        $this->registryManager = $registryManager;
    }

    /**
     *  Initial controller for first page orders display
     *
     * @Route("/", name="orderOverview")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('order_overview.html.twig', [
            'orders' => $this->registryManager->getRepository(Orders::class)->findAll(),
        ]);
    }

    /**
     * Control for viewing an order
     *
     * @Route("/order/{orderId}", name="orderView")
     *
     * @param int $orderId
     *
     * @return Response
     */
    public function viewOrder(int $orderId): Response
    {
        /** @var Orders $order */
        $order = $this->registryManager->getRepository(Orders::class)->find($orderId);
        $totalPrice = $order->getDeliveryMethodId() ? $order->getDeliveryMethodId()->getCost() : 0;
        $pizzas = [];
        $extras = [];

        // Collect order item entities and calculate order total
        /** @var OrderItems $orderItem */
        foreach ($order->getOrderItems() as $orderItem) {
            if ('pizza' === $orderItem->getOrderItemType()) {
                /** @var Pizza $pizza */
                $pizza = $this->registryManager->getRepository(Pizza::class)->find($orderItem->getOrderItemPizzaId());
                $pizzas[] = $pizza;
                $totalPrice = $totalPrice + $pizza->getCost()->getItemCost();
            } elseif ('extra' === $orderItem->getOrderItemType()) {
                /** @var PizzaIngredients $extra */
                $extra = $this->registryManager->getRepository(PizzaIngredients::class)->find($orderItem->getOrderItemPizzaId());
                $extras[] = $extra;
                $totalPrice = $totalPrice + $extra->getExtraCost();
            }
        }

        return $this->render('order_view.html.twig', [
            'order' => $order,
            'pizzas' => $pizzas,
            'extras' => $extras,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     *  Form to create a new order
     *
     * @Route("/add-order", name="addOrder")
     *
     * @return Response
     */
    public function addOrder(): Response
    {
        return $this->render('order_add.html.twig', [
            'pizzas' => $this->registryManager->getRepository(Pizza::class)->findAll(),
            'extras' => $this->registryManager->getRepository(PizzaIngredients::class)->findAll(),
            'deliveryMethods' => $this->registryManager->getRepository(DeliveryMethod::class)->findAll(),
            'drivers' => $this->registryManager->getRepository(DeliveryDriver::class)->findAll(),
        ]);
    }

    /**
     *  Ajax control to return option data
     *
     * @Route("/add-order-option", name="addOrderOption")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function ajaxAddOrderOption(Request $request): Response
    {
        // Check to ensure this is a post request
        if (!$request->isMethod('post')) {
            return new JsonResponse([
                'error' => true,
                'message' => 'Method is not allowed',
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $return = [];
        $orderId = $request->request->filter('orderId', 0, FILTER_VALIDATE_INT);
        $optionType = $request->request->filter('optionType', '', FILTER_SANITIZE_STRING);
        $optionId = $request->request->filter('optionId', 0, FILTER_VALIDATE_INT);

        // Check to ensure required data has been supplied
        if (empty($optionType) || empty($optionId)) {
            return new JsonResponse([
                'error' => true,
                'message' => 'Option data not provided',
            ], Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->registryManager->getManager();

        // Create order if orderId = 0 and add the item to the order
        if (empty($orderId)) {
            // Create a new order
            $order = new Orders();
            $entityManager->persist($order);
            $entityManager->flush();
            $orderId = $order->getId();
        } else {
            $order = $this->registryManager->getRepository(Orders::class)->find($orderId);
        }

        // Add order items to order, for pizzas and extras
        if (in_array($optionType, ['pizza', 'extra'])) {
            $orderItem = new OrderItems();
            $orderItem->setOrderId($order)
                ->setOrderItemType($optionType)
                ->setOrderItemPizzaId($optionId);
            $entityManager->persist($orderItem);
            $entityManager->flush();
        }

        // If optionType is driver set on order:
        if ('driver' === $optionType) {
            /** @var DeliveryDriver $driver */
            $driver = $this->registryManager->getRepository(DeliveryDriver::class)->find($optionId);
            $order->setDeliveryDriverId($driver);
            $entityManager->persist($order);
            $entityManager->flush();
            $return['driverName'] = $driver->getFirstName().' '.$driver->getLastName();
        }

        // Return price of item to display on order.
        switch ($optionType) {
            case 'pizza':
                /** @var Pizza $pizza */
                $pizza = $this->registryManager->getRepository(Pizza::class)->find($optionId);
                $return['name'] = $pizza->getName();
                $return['price'] = $pizza->getCost()->getItemCost();

                break;
            case 'extra':
                /** @var PizzaIngredients $extra */
                $extra = $this->registryManager->getRepository(PizzaIngredients::class)->find($optionId);
                $return['name'] = $extra->getName();
                $return['price'] = $extra->getExtraCost();

                break;
            case 'delivery':
                /** @var DeliveryMethod $delivery */
                $delivery = $this->registryManager->getRepository(DeliveryMethod::class)->find($optionId);

                // Set delivery method on order:
                $order->setDeliveryMethodId($delivery);
                $entityManager->persist($order);
                $entityManager->flush();

                $return['name'] = $delivery->getMethodName();
                $return['price'] = $delivery->getCost();

                break;
        }

        return new JsonResponse([
            'data' => $return,
            'orderId' => $orderId,
            'optionType' => $optionType,
            'optionId' => $optionId,
        ]);
    }
}
