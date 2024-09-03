<?php

namespace App\Docs;

/**
 * @OA\Schema(
 *     schema="ProductRequestBody",
 *     type="object",
 *     @OA\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="SKU",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="number",
 *         format="float"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="thumbnail",
 *         type="string",
 *         format="binary",
 *         description="Product thumbnail image"
 *     ),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(type="integer")
 *     ),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(type="string", format="binary"),
 *         description="Product gallery images"
 *     ),
 *     @OA\Property(
 *         property="deleted_images",
 *         type="array",
 *         @OA\Items(type="integer"),
 *         description="Product deleted images"
 *     ),
 * )
 */
class ProductSchema
{
}
