(function(){
	var app = angular.module('blogsampleApp', []);

	app.controller('pageController', function(){
		this.showBlog = true;
		
		this.switchShowBlog = function()
		{
			this.showBlog = !this.showBlog;		
		};
	});

	app.factory('loginService', function($http){
		var user = 'matildatilda@sample.com';

		return {
			getUser: function(){ return user; },
			login: function(userName, password)
			{
				var loginInfo = {};
				loginInfo.user = userName;
				loginInfo.password = password;

	            var config = {
    	            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}    
            	};

				$http.post('php/loginUser.php', $.param(loginInfo), config)
				.success(function(data, status){
					user = data.user;	
				})
				.error(function(data, status){
					user = '';	
				});
			},
			logout: function()
			{
				user = '';
			}	
		};	
	});

	app.controller('loginController', function(loginService)
	{
		this.user = "";
		this.password = "";
		this.showForm = false;
		this.loginService = loginService;

		this.setShowForm = function(show)
		{
			this.showForm = show;	
		};

		this.login = function()
		{
			loginService.login(this.user, this.password);	
			this.showForm = false;
			this.user = "";
			this.password = "";
		};
	});

	app.controller('blogController', function($http, $scope, loginService)
	{
		this.loginService = loginService;
		$scope.blogs = [];
		$scope.currentBlog = {};
		$scope.newBlog = {};
		$scope.updateBlog = {};
		$scope.maxNumOfBlogs = 0;
		
		this.startPage = 0;
		this.limitPage = 5;

		this.mode = {
			list: true,
			detail: false,
			edit: false,
			newAdd: false
		};

		this.showList = function()
		{
			this.mode.list = true;
			this.mode.detail = false;
			this.mode.edit = false;
			this.mode.newAdd = false;
		};
		
		this.showDetail = function()
		{
			this.mode.list = false;
			this.mode.detail = true;
			this.mode.edit = false;
			this.mode.newAdd = false;
		};
		
		this.showEdit = function()
		{
			this.mode.list = false;
			this.mode.detail = false;
			this.mode.edit = true;
			this.mode.newAdd = false;
		};

		this.showNewAdd = function()
		{
			this.mode.list = false;
			this.mode.detail = false;
			this.mode.edit = false;
			this.mode.newAdd = true;
		};

		this.prevPage = function()
		{
			this.startPage--;
			if (this.startPage < 0)
			{
				this.startPage = 0;	
			}
		};
		
		this.nextPage = function()
		{
			this.startPage++;
			var maxPages = Math.floor($scope.maxNumOfBlogs / this.limitPage);
			if (maxPages < this.startPage)
			{
				this.startPage = maxPages;	
			}
		};

		this.getBlogs = function()
		{
			var url = 'php/getBlogList.php?start='+this.startPage+'&limit='+this.limitPage;

			$http.get(url)
			.success(function(data, status){
				$scope.blogs = data;	
			})
			.error(function(data, status){
				$scope.blogs = [];	
			});
		};

		this.getMaxNumOfBlogs = function()
		{
			var url = 'php/getMaxNumOfBlogs.php?user='+loginService.getUser();

			$http.get(url)
			.success(function(data, status){
				$scope.maxNumOfBlogs = data.maxNumOfBlogs;
			})
			.error(function(data, status){
				$scope.maxNumOfBlogs = 0;	
			});
			
		};

		this.setCurrentBlog = function(blog)
		{
			$scope.currentBlog = blog;	
		};

		this.editBlog = function(blog)
		{
			$scope.updateBlog = blog;
		};

		this.addBlog = function(blog)
		{
			var _blog = {};
			_blog.user = loginService.getUser();
			_blog.title = blog.title;
			_blog.text_of_blog = blog.text_of_blog;

			//TODO: 要0埋め
			var today = new Date();
			_blog.created = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate() + " " 
						  + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var config = {
    			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}    
        	};

			$http.post('php/addBlog.php', $.param(_blog), config)
			.success(function(data, status){
				$scope.maxNumOfBlogs++;
				
			})
			.error(function(data, status){
			});
		};
		
		this.deleteBlog = function(blog)
		{
			var _blog = {};
			_blog.user = loginService.getUser();
			_blog.id = blog.id;
			
			var config = {
    			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}    
        	};

			$http.post('php/deleteBlog.php', $.param(_blog), config)
			.success(function(data, status){
				$scope.maxNumOfBlogs--;

			})
			.error(function(data, status){
			});
		};
		
		this.updateBlog = function(blog)
		{
			var _blog = {};
			_blog.user = loginService.getUser();
			_blog.id = blog.id;
			_blog.title = blog.title;
			_blog.text_of_blog = blog.text_of_blog;
			_blog.changeDate = blog.changeDate;
			var today = new Date();
			_blog.created = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate() + " " 
						  + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			
			var config = {
    			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}    
        	};

			$http.post('php/updateBlog.php', $.param(_blog), config)
			.success(function(data, status){
			})
			.error(function(data, status){
			});			
		};
	});

})();