<?php

it('has component page', function () {
    $response = $this->get('/component');

    $response->assertStatus(200);
});
