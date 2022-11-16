SELECT `order_item`.`product_name`, SUM(ROUND(`order_item`.price * (1-`order_item`.`discount`), 2)) AS total_price 
            FROM `order_item` INNER JOIN `product` ON `order_item`.`product_name` = `product`.`name` 
                              INNER JOIN `order` ON `order_item`.`order_id` = `order`.`id` 
            WHERE `order`.`date_checked` BETWEEN '2021-03-04' AND '2021-04-04'
            GROUP BY `order_item`.product_name 
            ORDER BY `total_price` DESC

SELECT `product`.name as 'name', 
		SUM(IF(`status`=1, 1, 0)) as 'actual_quantity_sold',
        SUM(ROUND(IF(`status`=1, `order_item`.price, 0), 2)) as 'actual_revenue',
        SUM(ROUND(IF(`status`=1, (`order_item`.price * `order_item`.discount), 0), 2)) as 'actual_discount',
        SUM(ROUND(IF(`status`=1, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'actual_total_revenue',
        SUM(IF(`status`=0, 1, 0)) as 'expected_quantity_sold',
        SUM(ROUND(IF(`status`=0, `order_item`.price, 0), 2)) as 'expected_revenue',
        SUM(ROUND(IF(`status`=0, (`order_item`.price * `order_item`.discount), 0), 2)) as 'expected_discount',
        SUM(ROUND(IF(`status`=0, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'expected_total_revenue'
        FROM `order_item` INNER JOIN `product` ON `order_item`.`product_name` = `product`.`name` 
                            INNER JOIN `order` ON `order_item`.`order_id` = `order`.`id` 
        GROUP BY `order_item`.product_name 
        ORDER BY `total_price` DESC

SELECT `genre`.name as 'name', 
        SUM(IF(`status`=1, 1, 0)) as 'actual_quantity_sold',
        SUM(ROUND(IF(`status`=1, `order_item`.price, 0), 2)) as 'actual_revenue',
        SUM(ROUND(IF(`status`=1, (`order_item`.price * `order_item`.discount), 0), 2)) as 'actual_discount',
        SUM(ROUND(IF(`status`=1, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'actual_total_revenue',
        SUM(IF(`status`=0, 1, 0)) as 'upcomming_quantity_sold',
        SUM(ROUND(IF(`status`=0, `order_item`.price, 0), 2)) as 'upcomming_revenue',
        SUM(ROUND(IF(`status`=0, (`order_item`.price * `order_item`.discount), 0), 2)) as 'upcomming_discount',
        SUM(ROUND(IF(`status`=0, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'upcomming_total_revenue'
        FROM `order_item` INNER JOIN `product` ON `order_item`.`product_name` = `product`.`name` 
                          INNER JOIN `order` ON `order_item`.`order_id` = `order`.`id` 
                          INNER JOIN `product_genre` ON `product_genre`.`product_name` = `product`.`name`
                          INNER JOIN `genre` ON `product_genre`.`genre_name` = `genre`.`name`
        GROUP BY `genre`.name