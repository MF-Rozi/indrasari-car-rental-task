<?php

test('the application redirects root to catalog', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('catalog.index'));
});
