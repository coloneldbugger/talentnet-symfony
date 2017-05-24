<?php
describe("ProductController", function() {
	describe("->getAction", function() {
		it("returns an array of products", function() {
			$controller = new ProductController();
			
			ob_start();
			$controller->getAction();
			$actual = ob_get_clean();
			
			expect($actual)->toBeA('array');
		});
	});
});