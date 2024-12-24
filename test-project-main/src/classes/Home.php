<?php

class Home
{
    public function index()
    {
        global $smarty;
        $games = [
            1 => 'Game 1',
            2 => 'Game 2',
            3 => 'Game 3',
        ];

        $products = [
            [
                'id' => 1,
                'name' => 'Product 1',
                'stock' => 10,
                'min_order' => 1,
                'max_order' => 5,
                'price' => 100
            ],
            [
                'id' => 2,
                'name' => 'Product 2',
                'stock' => 20,
                'min_order' => 1,
                'max_order' => 5,
                'price' => 200
            ],
            [
                'id' => 3,
                'name' => 'Product 3',
                'stock' => 30,
                'min_order' => 1,
                'max_order' => 5,
                'price' => 300
            ],
        ];

        $data = [
            'games' => $games;
            'products' => $products;
        ];
        $jsonData = json_encode($data);

        $url = 'https://www.turkpin.net/api.php';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response);
        
        $games = $this ->gamesAPI();
        $products = $this->productsAPI();

        $selected_game = isset($_GET['game_id']) ? $_GET['game_id'] : 0;
        $smarty ->assign('selected_game', $selected_game);
        
        $products = [];
        if($selected_game != 0){
            $products = $this->productsAPI($selected_game);
    }

    $smarty->assign('games', $games);
    $smarty->assign('products', $products);
    $smarty->assign('template', 'home.html');
    
    private function gamesAPI()
    {
        $url = 'https://www.turkpin.net/api.php';
        $response = file_get_contents($url);
        $games = json_decode($response, true);
        return $games;
    }
    private function productsAPI()
    {
        $url = 'https://www.turkpin.net/api.php';
        $response = file_get_contents($url);
        $products = json_decode($response, true);
        return $products;
    }
}
}
