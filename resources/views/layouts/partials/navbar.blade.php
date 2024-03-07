<!-- BEGIN: Breadcrumb -->
<div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
<!-- END: Breadcrumb -->
<!-- BEGIN: Search 
<div class="intro-x relative mr-3 sm:mr-6">
   <div class="search hidden sm:block">
      <input type="text" class="search__input input placeholder-theme-13" placeholder="Search...">
      <i data-feather="search" class="search__icon dark:text-gray-300"></i> 
   </div>
   <a class="notification sm:hidden" href=""> <i data-feather="search" class="notification__icon dark:text-gray-300"></i> </a>
   <div class="search-result">

   </div>
</div>
END: Search -->

<!-- BEGIN: Account Menu -->
<div class="intro-x dropdown w-8 h-8">
   <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
      <img alt="Midone Tailwind HTML Admin Template" src={{asset("dist/images/profile-1.jpg")}}>
   </div>
   <div class="dropdown-box w-56">
      <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
         <div class="p-4 border-b border-theme-40 dark:border-dark-3">
            <div class="font-medium">{{ $user = auth()->user()->name;}}</div>
            <!--<div class="text-xs text-theme-41 dark:text-gray-600">DevOps Engineer</div>-->
         </div>
         
         <div class="p-2 border-t border-theme-40 dark:border-dark-3">
            <a href="{{ route('logout') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
         </div>
      </div>
   </div>
</div>
<!-- END: Account Menu -->
