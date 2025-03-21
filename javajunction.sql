-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 10:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `javajunction`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status_active` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id_admin`, `username`, `email`, `password`, `status_active`) VALUES
(7, 'azis', 'nurazissaputra@gmail.com', '$2y$10$0iVdPLpAQfZVtUnSPP3W4uKS32a2OKRTmCLB18AIauwh4EfR8PMby', 'yes'),
(18, 'keren', 'trinitapermatacarenpolii@gmail.com', '$2y$10$5wr1l8nrmk9Yj4MM2umG0uywOQ43Zgzextq8LJW8s85qi0E0iMu52', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` char(20) NOT NULL,
  `id_user` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`) VALUES
('Z1owpEnMc7jo1sqdbi9A', '7ojQfY5bkJ7CKNcKiiOA'),
('22gaDqwtx9srHNG3SZgS', '8ER9LbywJJwWGCD8zlNe'),
('9ygpyeMEjdooakZH1ugE', 'aBs0EXrzqdCLT00Tyjlx'),
('DtxdCuJSeFZO5V7fLHVr', 'ai5KIWWsl9jXcdNEqtq8'),
('hSVS1rl548cCZYghNpkq', 'ai5KIWWsl9jXcdNEqtq8'),
('KbgxWLBZSLxKFGnBZHXG', 'ai5KIWWsl9jXcdNEqtq8'),
('Sm8xYcM0QDUOmX2CDnPs', 'ai5KIWWsl9jXcdNEqtq8'),
('stFUCW4vdqNgVbsine4y', 'C5yRexN0l6ZRelfYng9u'),
('j1a1iAtm0efcFVqRdrU9', 'fDhKMgEvbYaTbJSTl0VZ'),
('JTo6NutfDQnzN8nfFPYZ', 'fV4CxYSebvbRdUc2thfd'),
('UsbljH8UF3VADvD9Vv04', 'GXsxtONRPAZSRHjP4wBe'),
('zffSlkY1UgJuawtjV6SM', 'm15BQ5Wdf5AXs8DCACqj'),
('X1RzEpUEECstLg90F9ZY', 'pqhWhIPhDcCnCDF0Gpt9'),
('uG1cpAx9evsZAO7so9iF', 'RI8A6L9t4aAKRjTaxcGP'),
('1GYwiQJDBjdt0gqUyxTW', 'u43iSztax7Df0Psf4zR1'),
('6QIJgCRBxycCkGEd2JaB', 'u43iSztax7Df0Psf4zR1'),
('8pKEPshWMTWEGPGFGo86', 'u43iSztax7Df0Psf4zR1'),
('aIIVumj37lViU3Ws9dA5', 'u43iSztax7Df0Psf4zR1'),
('bvsao96ECnAsTy0HBt3U', 'u43iSztax7Df0Psf4zR1'),
('bYAPIRbFozfOnAwOxnz3', 'u43iSztax7Df0Psf4zR1'),
('dS5lczb5C7wQaRDnS1Js', 'u43iSztax7Df0Psf4zR1'),
('dSCdJFXEsyM7VfarLqOy', 'u43iSztax7Df0Psf4zR1'),
('f3NuoCOLXbgzMZKIMPDs', 'u43iSztax7Df0Psf4zR1'),
('g7E8e0PXTHV9Orb4z3qU', 'u43iSztax7Df0Psf4zR1'),
('ICx8FNuhTlgUA2dvBgj8', 'u43iSztax7Df0Psf4zR1'),
('iGmXwre9B4Yk6KbbsmP2', 'u43iSztax7Df0Psf4zR1'),
('ikQTGSLxlDDWP8HPawj0', 'u43iSztax7Df0Psf4zR1'),
('LCt8oAKC9ScmPUgzx8Tm', 'u43iSztax7Df0Psf4zR1'),
('LNp5reZtzixExVGe3rYP', 'u43iSztax7Df0Psf4zR1'),
('MigyA3OJj5gJVTUO1oC2', 'u43iSztax7Df0Psf4zR1'),
('n1AUZPnX2U8BaAdq6Ech', 'u43iSztax7Df0Psf4zR1'),
('pyiU8lVHDTAZ0IW3AXFo', 'u43iSztax7Df0Psf4zR1'),
('sdZFMeuaopbdkubvbccy', 'u43iSztax7Df0Psf4zR1'),
('Tidwq9qKlPqi8L3Uhsxt', 'u43iSztax7Df0Psf4zR1'),
('WW9GOSMCNfTBDVWOyGSz', 'u43iSztax7Df0Psf4zR1'),
('XRyFe54BhBxvmhrvpeqz', 'u43iSztax7Df0Psf4zR1'),
('YepaAVyRbmsokfdaqCOJ', 'u43iSztax7Df0Psf4zR1'),
('zIHxdJbzsOP6Ceq0XoEx', 'u43iSztax7Df0Psf4zR1'),
('f8nJPqvBC18q2q0Z9yV8', 'ut1BSLxL27bTV9UGfUDn'),
('JSmjbgbiKhfLGIWYADQe', 'Z3pxmfYa4r03VElYLhRb');

-- --------------------------------------------------------

--
-- Table structure for table `detail_cart`
--

CREATE TABLE `detail_cart` (
  `id_cart` varchar(20) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_cart`
--

INSERT INTO `detail_cart` (`id_cart`, `id_product`, `quantity`) VALUES
('hSVS1rl548cCZYghNpkq', 19, 4),
('uG1cpAx9evsZAO7so9iF', 19, 6),
('JTo6NutfDQnzN8nfFPYZ', 22, 1),
('KbgxWLBZSLxKFGnBZHXG', 22, 1),
('DtxdCuJSeFZO5V7fLHVr', 26, 1),
('X1RzEpUEECstLg90F9ZY', 25, 1),
('Sm8xYcM0QDUOmX2CDnPs', 21, 1),
('JSmjbgbiKhfLGIWYADQe', 32, 1),
('j1a1iAtm0efcFVqRdrU9', 22, 1),
('UsbljH8UF3VADvD9Vv04', 32, 1),
('UsbljH8UF3VADvD9Vv04', 22, 1),
('UsbljH8UF3VADvD9Vv04', 28, 1),
('9ygpyeMEjdooakZH1ugE', 9, 1),
('f8nJPqvBC18q2q0Z9yV8', 23, 1),
('zffSlkY1UgJuawtjV6SM', 22, 1),
('LNp5reZtzixExVGe3rYP', 26, 4),
('sdZFMeuaopbdkubvbccy', 23, 2),
('Z1owpEnMc7jo1sqdbi9A', 26, 1),
('Z1owpEnMc7jo1sqdbi9A', 27, 3),
('Z1owpEnMc7jo1sqdbi9A', 32, 2),
('f8nJPqvBC18q2q0Z9yV8', 24, 1),
('iGmXwre9B4Yk6KbbsmP2', 23, 1),
('zIHxdJbzsOP6Ceq0XoEx', 23, 1),
('6QIJgCRBxycCkGEd2JaB', 23, 1),
('g7E8e0PXTHV9Orb4z3qU', 23, 1),
('n1AUZPnX2U8BaAdq6Ech', 21, 1),
('dSCdJFXEsyM7VfarLqOy', 22, 2),
('MigyA3OJj5gJVTUO1oC2', 22, 1),
('YepaAVyRbmsokfdaqCOJ', 22, 1),
('bvsao96ECnAsTy0HBt3U', 22, 1),
('WW9GOSMCNfTBDVWOyGSz', 19, 1),
('XRyFe54BhBxvmhrvpeqz', 19, 1),
('bYAPIRbFozfOnAwOxnz3', 19, 1),
('dS5lczb5C7wQaRDnS1Js', 19, 2),
('dS5lczb5C7wQaRDnS1Js', 21, 1),
('f3NuoCOLXbgzMZKIMPDs', 19, 1),
('Tidwq9qKlPqi8L3Uhsxt', 21, 1),
('1GYwiQJDBjdt0gqUyxTW', 19, 1),
('LCt8oAKC9ScmPUgzx8Tm', 19, 1),
('ICx8FNuhTlgUA2dvBgj8', 24, 1),
('ikQTGSLxlDDWP8HPawj0', 19, 1),
('8pKEPshWMTWEGPGFGo86', 23, 1),
('aIIVumj37lViU3Ws9dA5', 19, 4),
('aIIVumj37lViU3Ws9dA5', 22, 1),
('pyiU8lVHDTAZ0IW3AXFo', 20, 1),
('pyiU8lVHDTAZ0IW3AXFo', 21, 1),
('pyiU8lVHDTAZ0IW3AXFo', 23, 7),
('stFUCW4vdqNgVbsine4y', 20, 1),
('22gaDqwtx9srHNG3SZgS', 1, 2),
('22gaDqwtx9srHNG3SZgS', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `invoice` varchar(12) NOT NULL,
  `id_cart` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address_table` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `grand_price` int(10) NOT NULL,
  `quantity` int(2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`invoice`, `id_cart`, `name`, `number`, `email`, `address_table`, `address_type`, `method`, `grand_price`, `quantity`, `date`, `status`, `id_admin`) VALUES
('251522558947', '22gaDqwtx9srHNG3SZgS', 'rans', '11111', '', 'a1', 'dine in', 'cash', 90000, 3, '2023-12-18 16:31:29', 'order in process', 18),
('881294191771', 'stFUCW4vdqNgVbsine4y', 'Ker', '0811', '', 'a2', 'dine in', 'cash', 28000, 1, '2023-12-18 14:54:13', 'completed', 7);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `category` varchar(15) DEFAULT NULL,
  `price` int(10) NOT NULL,
  `status` enum('active','draft','empty') NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `product_name`, `description`, `category`, `price`, `status`, `stock`, `image`) VALUES
(1, 'Red Valvet Roll Cake', 'Velvety red jelly rolled cake blend with praline nuts', 'meal', 30000, 'empty', 8, 'Red-valvet-roll-cake.jpg'),
(2, 'Classic Dark Chocolate Cake', 'A classic Cake with Dark chocolate ganache', 'meal', 40000, 'active', 10, 'Classic-Dark-Chocolate-Cake.jpg'),
(3, 'Oreo Cheesecake', 'A classic twist with Cheesecake and Oreo bit', 'meal', 37000, 'active', 10, 'Oreo-cheesecake.jpg'),
(4, 'Avocado Medley Cake', 'A mousse cake with Avocado Creme and Chocolate Mousse', 'meal', 39000, 'active', 10, 'Avocado-medley-cake.jpg'),
(5, 'Vanilla Cheesecake', 'A typical sponge cake with Vanilla Custard Keju filling', 'meal', 27000, 'active', 10, 'Cheesecake.jpg'),
(6, 'Green Tea and Ogura Swiss Roll ', 'Green tea roll cake spreads with green tea cream and ogura.', 'meal', 45000, 'active', 10, 'Green-and-ogura-swissroll.jpg'),
(7, 'Green Tea Latte', 'Smooth and creamy matcha is lightly sweetened and served with steamed milk.', 'cold drink', 57000, 'active', 10, 'Greentea-Latte.jpg'),
(8, 'Caramel Cream Frappuccino', 'Milk blended with caramel sauce and ice then topped with whipped cream and caramel drizzle.', 'cold drink', 37000, 'active', 10, 'Caramel-frappuccino.jpg'),
(9, 'Earl Grey Tea Latte', 'Sweetened earl grey tea with some steamed milk and vanilla syrup.', 'cold drink', 53000, 'active', 10, 'Earl-grey-tea-latte.jpg'),
(10, 'Mango Passion Frappuccino', 'A tropical mango and passionfruit infusion, perfectly blended with a fruity hibiscus tea and ice.', 'cold drink', 28000, 'active', 10, 'Manggo-pasion-frapucinno.jpg'),
(11, 'Vanilla Cream Frappuccino', 'A rich, creamy mixture of vanilla beans, milk, and ice with whipped cream on top ', 'cold drink', 55000, 'active', 10, 'Vanilla-frapucinno.jpg'),
(12, 'Signature Chocolate', 'Chocolate and dairy milk, steamed together to create a hot chocolate fit for a chocaholic! Topped with whipped cream and dusted with cocoa.', 'cold drink', 55000, 'active', 10, 'Signature-chocolate.jpg'),
(13, 'Potato Chips', 'It is made from thinly sliced potatoes that are fried or baked until they become crispy and golden brown. ', 'snack', 25000, 'active', 10, 'Potato-chips.jpg'),
(14, 'Popcorn', 'Popcorn is a snack made from dried corn kernels that have been heated until they break and rise. and seasoned with salty spices', 'snack', 35000, 'active', 10, 'Popcorn.jpg'),
(15, 'Crackers', 'Crackers are crunchy, thin, salty snacks made from flour, water, and various seasonings. Coupled with cheese toppings', 'snack', 32000, 'active', 10, 'Crackers.jpg'),
(16, 'Roasted Nuts', 'Cooked or baked in the oven or on the stove. This process enhances the taste, texture, and aroma and then adds salty seasoning', 'snack', 27000, 'active', 10, 'Roasted-nuts.jpg'),
(17, 'Chocolate Bars', ' It is made from cocoa, sugar, and uses milk. ', 'snack', 20000, 'active', 10, 'Chocolatte-bars.jpg'),
(18, 'Onion Ring', 'Made from sliced onions covered in batter or bread crumbs and fried until they become crispy and golden brown. ', 'snack', 45000, 'active', 10, 'Onion-ring.jpg'),
(19, 'Mocha', 'Espresso with bittersweet mocha sauce and steamed milk, topped with sweetened whipped cream. Delightful.', 'hot coffee', 48000, 'draft', 50, 'Mocha.jpg'),
(20, 'Americano', 'Espresso with hot water', 'hot coffee', 28000, 'active', 8, 'Americano.jpg'),
(21, 'Cappucino', 'Espresso with steamed milk, topped with a deep layer of foam.', 'hot coffee', 32000, 'active', 7, 'Cappuccino.jpg'),
(22, 'Latte', 'Rich, full-bodied espresso in steamed milk, lightly topped with foam. A caffe latte is simply a shot or two of bold, tasty espresso with fresh, sweet steamed milk over it.', 'hot coffee', 34000, 'active', 8, 'Latte.jpg'),
(23, 'Flat White', 'Expertly steamed milk poured over a double shot of our signature espresso and finished with a thin layer of velvety microfoam.', 'hot coffee', 40000, 'empty', 0, 'Flat-white.jpg'),
(24, 'Espresso Con Panna', 'The delicate dollop of whipped cream softens the rich and caramelly espresso flavours so exquisitely, you may choose to forego adding sugar altogether.', 'hot coffee', 35000, 'active', 10, 'Espresso-con panna.jpg'),
(25, 'Cold Brew', 'Cold Brew is a refreshing coffee beverage made by steeping coarsely', 'cold coffee', 45000, 'active', 10, 'Brew-Coffee.jpg'),
(26, 'Iced Coffee', 'Iced Coffee is a classic coffee drink that is brewed hot and then cooled down by adding ice.', 'cold coffee', 30000, 'active', 9, 'Iced-Coffee-At-Home.jpeg'),
(27, 'Frapprucino', 'Frappuccino is a blended coffee beverage that combines coffee, ice, milk, and various flavorings', 'cold coffee', 35000, 'active', 10, 'homemade-frappuccino.jpg'),
(28, 'Coffee Shake', 'A Coffee Shake is a creamy and satisfying concoction that blends coffee with ice cream and milk', 'cold coffee', 45000, 'active', 10, 'Shake-Recipe.jpeg'),
(29, 'Cold Latte', 'Cold Latte is a chilled coffee made by mixing espresso with cold milk and ice. It offers a milder', 'cold coffee', 35000, 'active', 10, 'Caramel-Latte.jpg'),
(30, 'mocha frappe', 'Mocha Frappe is a delightful variation of the Frappuccino, combining coffee with chocolate flavors', 'cold coffee', 45000, 'active', 10, 'Mocha-Recipe.jpeg'),
(31, 'Sandwich', 'A sandwich is a versitile and convenient meal made by placing various fillinfs, such as meat', 'heavy meal', 25000, 'active', 10, 'short-eats.jpeg'),
(32, 'Burger ', 'A burger is a classic American dish, consisting of a ground meat patty, often beef, and cooked  ', 'heavy meal', 35000, 'active', 10, 'burger.jpeg'),
(33, 'Salad', 'Salad is a light and healthy dish made from a mix of fresh vegetables, greens, and sometimes ', 'heavy meal', 25000, 'active', 10, 'chicken-salad.jpeg'),
(34, 'Pasta', 'Pasta is an Italian staple that comes in various shapes and sizes. It\'s typically boiled and served', 'heavy meal', 30000, 'active', 10, 'pasta-chicken.jpeg'),
(35, 'fried Rice', 'Fried rice is a flavorful dish made by stir-frying cooked rice with vegetables, protein (such as chicken)', 'heavy meal', 20000, 'active', 10, 'nasi-goreng.jpeg'),
(36, 'Steak', 'Steak is a premium cut of meat, usually beef, that is cooked to desired levels of doneness it\'s know for its juicy', 'heavy meal', 10000, 'active', 10, 'beef-steak.jpeg'),
(37, 'Tiramisu French Toast', 'Tiramisu French Toast is toasted bread smeared with a mixture of mascarpone cheese, honey and ground coffee which brings out the taste of tiramisu.', 'snack', 50000, 'active', 10, 'tiramisu.jpg '),
(38, 'French Toast Stiks', 'French toast sticks are cinnamon toast with a crunchy texture and topped with apple syrup', 'snack', 45000, 'active', 10, 'french Toast Sticks.jpg '),
(39, 'Croissant ', 'Croissants are a type of pastry product made from folded dough, with sweet fillings such as chocolate and cream', 'snack', 45000, 'active', 10, 'Croissant.jpg '),
(40, 'Strawberry Lemon Croissant', 'Croissants are a type of pastry product made from folded dough, filled with cream with fresh fruit and topped with a topping of sugar mixed with fruit syrup.', 'snack', 59900, 'active', 10, 'STRAWBERRY-LEMON-CROISSANT.jpg '),
(41, 'Cream Cheese Muffins', 'Cream cheese which is processed into delicious muffins has a soft texture with a dominant creamy taste, filled with swirls of cream cheese and topped with crumbly butter topping', 'snack', 45000, 'active', 10, 'Cream Cheese Muffins.jpg '),
(42, 'Cupcake Muffin Vanilla', 'Delicious vanilla muffin cupcakes have a soft texture with a dominant creamy taste, and are topped with vanilla cream and fresh fruit', 'snack', 25000, 'active', 10, 'Cupcake muffin vanilla.jpg '),
(43, 'Doughnut Ice Cream', 'Donuts are round-shaped cakes with a hole in the middle with many variations of toppings, the newest donuts currently are filled with ice cream', 'snack', 39900, 'active', 10, 'Doughnut ice Cream.jpg '),
(44, 'Sweet Pastries (Baklava)', 'Baklava is a popular Turkiye dessert, a pastry filled with sticky sweet nuts', 'snack', 50000, 'active', 10, 'Baklava.jpeg '),
(45, 'Scone', 'A scone is a single-serving or quick bread, and is served with jam and whipped cream', 'snack', 40000, 'active', 10, 'Scone.jpg '),
(46, 'Mocha Scones', 'These mocha scones are tender, flaky and full of espresso. Espresso scone dough with chocolate chunks and topped with an espresso glaze.', 'snack', 35000, 'active', 10, 'Mocha-Scones.jpg'),
(47, 'Thai Beef Omelette', 'Thai beef omelet, with egg base and minced beef filling cooked with spices and fragrant basil leaves', 'meal', 65000, 'active', 10, 'Thai beef omelette.jpg '),
(48, 'Chicken Omelette', 'Chicken Omelette is made with large eggs, shredded chicken, vegetables, and grated cheese', 'meal', 50000, 'active', 10, 'Chicken Omelette.jpg '),
(49, 'Pepperoni-Bbq Chicken', 'BBQ chicken pizza sweet BBQ sauce, tangy gouda, creamy mozzarella, and red onions and cilantro for freshness', 'meal', 80000, 'active', 10, 'Pepperoni-BBQ Chicken.jpg '),
(50, 'Maki Sushi Rolls', 'This type of sushi, which is usually called norimaki, has a round shape filled with various side dishes, such as slices of cucumber, salmon, beef, eggs, seafood, vegetables, avocado, and others.', 'meal', 95000, 'active', 10, 'Maki-sushi-rolls.jpg '),
(51, 'Nigiri Sushi', 'Nigiri is a dish containing sliced ??raw fish (sashimi) served on vinegared rice (sushi) in an oval shape.', 'meal', 125000, 'active', 10, 'Nigiri-sushi.jpg '),
(52, 'Veggie Tacos', 'The vegetarian taco is a tortilla shell filled with black beans, grilled vegetables, and avocado tomatillo sauce', 'meal', 45000, 'active', 10, 'Veggie-Tacos.jpg '),
(53, 'Beef Tacos', 'Beef tacos are tortilla shells filled with beef', 'meal', 60000, 'active', 10, 'Beef Tacos.jpg '),
(54, 'Beef Burritos', 'Beef Burrito, filled with super delicious simple seasoned beef, rice, and other choice fillings.', 'meal', 65000, 'active', 10, 'beef burritos.jpg '),
(55, 'Omlet', 'omlet is a processed food that has the basic ingredients of eggs, grated cheese, liquid milk and vegetables such as carrots, green beans, broccoli etc, with a denser texture.', 'meal', 40000, 'active', 10, 'omlet.jpg ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `detail_cart`
--
ALTER TABLE `detail_cart`
  ADD KEY `id_cart` (`id_cart`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`invoice`),
  ADD KEY `id_cart` (`id_cart`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `detail_cart` (`id_cart`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_cart`
--
ALTER TABLE `detail_cart`
  ADD CONSTRAINT `detail_cart_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `administrator` (`id_admin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
