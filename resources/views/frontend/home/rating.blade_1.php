<?php
if (sizeof($product->rating) == 0) {
    ?>
    <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
    <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
    <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
    <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
    <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
    <?php
} else {
    $total = $index = 0;
    foreach ($product->rating as $rate) {
        $total += $rate->rate;
        $index++;
    }
    $finley_rate = $total / $index;
    $finley_rate = round($finley_rate);
    ?>
    <?php foreach (range(1, $finley_rate) as $rating): ?>
        <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star light"></i></a>
        <?php
    endforeach;
    while ($finley_rate < 5):
        ?>
        <a href="{{ url('product/'.$product->id)}}"><i class="fa fa-star dark"></i></a>
        <?php
        $finley_rate++;
    endwhile;
}
