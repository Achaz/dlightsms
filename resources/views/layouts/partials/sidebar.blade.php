<nav class="side-nav">
   <a href="" class="intro-x flex items-center pl-5 pt-4">
   <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/dlight_logo.svg') }}">
   <span class="hidden xl:block text-white text-lg ml-3"> d.light<span class="font-medium">Uganda</span> </span>
   </a>
   <div class="side-nav__devider my-6"></div>
   <ul>
      <li>
         <a href="{{ route('dashboard') }}" class="side-menu side-menu--active">
            <div class="side-menu__icon"> <i data-feather="home"></i> </div>
            <div class="side-menu__title"> Dashboard </div>
         </a>
      </li>
      @can('admin.menu')
      <li class="side-nav__devider my-6"></li>
      <li>
         <a href="javascript:;" class="side-menu">
            <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
            <div class="side-menu__title"> Admin Panel <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
         </a>
         <ul class="">
            <li>
               <a href="{{ route('users.index') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> View Users </div>
               </a>
            </li>
            <li>
               <a href="{{ route('roles.index') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Manage Roles </div>
               </a>
            </li>
            <li>
               <a href="{{ route('permissions.index') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Permissions </div>
               </a>
            </li>
            <li>
               <a href="{{ route('register') }}" class="side-menu ? 'active' : ''">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Add Users </div>
               </a>
            </li>
         </ul>
      </li>  
      @endcan
      <div class="side-nav__devider my-6"></div>
      <li>
         <a href="javascript:;" class="side-menu">
            <div class="side-menu__icon"> <i data-feather="list"></i> </div>
            <div class="side-menu__title"> lists <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
         </a>
         <ul class="">
            <li>
               <a href="{{ route('lists.addlist') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> New list </div>
               </a>
            </li>
            <li>
               <a href="{{ route('lists.managelist') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Manage list </div>
               </a>
            </li>
            <li>
               <a href="{{ route('lists.addressbook') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Address Book </div>
               </a>
            </li>
         </ul>
      </li>   
      <div class="side-nav__devider my-6"></div>
      <li>
         <a href="javascript:;" class="side-menu">
            <div class="side-menu__icon"> <i data-feather="twitch"></i> </div>
            <div class="side-menu__title"> Broadcast <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
         </a>
         <ul class="">
            <li>
               <a href="{{ route('broadcasts.mosms') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Inbox </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.singlesms') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Single Sms </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.bulksms') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Bulk Sms </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.schedulemessages') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Schedule SMS </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.viewscheduledmessages') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> View Scheduled Message </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.smstemplate') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> SMS Templates </div>
               </a>
            </li>
            <li>
               <a href="{{ route('broadcasts.keywords') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Keywords </div>
               </a>
            </li>
         </ul>
      </li>
      
      @can('credits.menu')
      <div class="side-nav__devider my-6"></div>
      <li>
         <a href="javascript:;" class="side-menu">
            <div class="side-menu__icon"> <i data-feather="tag"></i> </div>
            <div class="side-menu__title"> Credits <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
         </a>
         <ul class="">
            <li>
               <a href="{{ route('credits.assigncredit') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Assign Credits </div>
               </a>
            </li>
            <li>
               <a href="{{ route('credits.index') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Your Credits </div>
               </a>
            </li>
            <li>
               <a href="{{ route('credits.credithistories') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Credit History </div>
               </a>
            </li>
         </ul>
      </li>
      @endcan    
      <div class="side-nav__devider my-6"></div>
      <li>
         <a href="javascript:;" class="side-menu">
            <div class="side-menu__icon"> <i data-feather="trending-up"></i> </div>
            <div class="side-menu__title"> Reports <i data-feather="chevron-down" class="side-menu__sub-icon"></i> </div>
         </a>
         <ul class="">
            <li>
               <a href="{{ route('reports.smsreports') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> SMS Reports </div>
               </a>
            </li>
            <li>
               <a href="{{ route('reports.bulkdeliveryreports') }}" class="side-menu">
                  <div class="side-menu__icon"> <i data-feather="arrow-right"></i> </div>
                  <div class="side-menu__title"> Bulk Delivery Reports </div>
               </a>
            </li>
         </ul>
      </li>     
   </ul>
</nav>