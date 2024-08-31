@php use App\Models\Role; @endphp
<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <img src="{{ getFilePath('') }}" alt="House Brand" height="60px" width="auto">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        @if (hasPermission('dashboard_read'))
            <li class="menu-item {{ activeMenu('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="{{ _trans('common.Dashboard') }}">{{ _trans('common.Dashboard') }}</div>
                </a>
            </li>
        @endif

        @if (hasPermission('product_management_read'))
            <li class="menu-item {{ openMenu(['admin.category', 'admin.product']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-color-swatch"></i>
                    <div data-i18n="{{ _trans('product.Product') }} {{ _trans('product.Management') }}">
                        {{ _trans('product.Product') }} {{ _trans('product.Management') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('product_read'))
                        <li class="menu-item {{ activeMenu('product') }}">
                            <a href="{{ route('admin.product.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('product.Products') }}">{{ _trans('product.Products') }}
                                </div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('category_read'))
                        <li class="menu-item {{ activeMenu('admin.category') }}">
                            <a href="{{ route('admin.category.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('product.Categories') }}">{{ _trans('product.Categories') }}
                                </div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        {{-- @if (hasPermission('order_management_read'))
            <li class="menu-item {{ openMenu(['order', 'myOrder', 'order-claim', 'cart', 'productRequest']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-truck"></i>
                    <div data-i18n="{{ _trans('order.Order') }} {{ _trans('product.Management') }}">
                        {{ _trans('order.Order') }} {{ _trans('product.Management') }}</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ openMenu(['order', 'order-claim', 'cart', 'productRequest']) }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">

                            <div data-i18n="{{ _trans('order.Customer') . ' ' . _trans('order.Order') }}">
                                {{ _trans('order.Customer') . ' ' . _trans('order.Order') }}</div>
                        </a>
                        <ul class="menu-sub">
                            @if (hasPermission('customer_cart_list_read'))
                                <li class="menu-item  {{ activeMenu('cart.*') }}">
                                    <a href="{{ route('cart.index') }}" class="menu-link">
                                        <div data-i18n="{{ _trans('order.Cart') . ' ' . _trans('order.List') }}">
                                            {{ _trans('order.Cart') . ' ' . _trans('order.List') }}</div>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('customer_order_list_details'))
                                <li class="menu-item {{ activeMenu('order') }}">
                                    <a href="{{ route('order.index') }}" class="menu-link">
                                        <div data-i18n="{{ _trans('order.Order') . ' ' . _trans('order.List') }}">
                                            {{ _trans('order.Order') . ' ' . _trans('order.List') }}</div>
                                    </a>
                                </li>
                            @endif
                            @if (hasPermission('customer_order_claim_read'))
                                <li class="menu-item {{ activeMenu('order-claim') }}">
                                    <a href="{{ route('order-claim.index') }}" class="menu-link">
                                        <div data-i18n="{{ _trans('order.Order') . ' ' . _trans('order.Claim') }}">
                                            {{ _trans('order.Order') . ' ' . _trans('order.Claim') }}</div>
                                    </a>
                                </li>
                            @endif

                            @if (hasPermission('customer_order_product_request_read'))
                                <li class="menu-item {{ activeMenu('productRequest') }}">
                                    <a href="{{ route('productRequest.index') }}" class="menu-link">
                                        <div
                                            data-i18n="{{ _trans('product.Product') . ' ' . _trans('contact.Request') }}">
                                            {{ _trans('product.Product') . ' ' . _trans('contact.Request') }}</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    @if (hasPermission('my_order_read'))
                        <li class="menu-item {{ openMenu(['myOrder']) }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="{{ _trans('order.My') . ' ' . _trans('order.Order') }}">
                                    {{ _trans('order.My') . ' ' . _trans('order.Order') }}</div>
                            </a>
                            <ul class="menu-sub">
                                @if (hasPermission('my_order_cart_list_read'))
                                    <li class="menu-item {{ activeMenu('myOrder.cart.*') }}">
                                        <a href="{{ route('myOrder.cart.index') }}" class="menu-link">
                                            <div data-i18n="{{ _trans('order.Cart') . ' ' . _trans('order.List') }}">
                                                {{ _trans('order.Cart') . ' ' . _trans('order.List') }}</div>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('my_order_list_read'))
                                    <li class="menu-item {{ activeMenu('myOrder.order.*') }}">
                                        <a href="{{ route('myOrder.order.index') }}" class="menu-link">
                                            <div data-i18n="{{ _trans('order.Order') . ' ' . _trans('order.List') }}">
                                                {{ _trans('order.Order') . ' ' . _trans('order.List') }}</div>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                    @endif
                </ul>
            </li>

        @endif

        @if (hasPermission('portfolio_and_inspiration_read'))
            <li class="menu-item {{ openMenu(['section']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-map"></i>
                    <div data-i18n="{{ _trans('portfolio.Portfolio') }} & {{ _trans('portfolio.Inspiration') }}">
                        {{ _trans('portfolio.Portfolio') }} & {{ _trans('portfolio.Inspiration') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('section_category_read'))
                        <li class="menu-item {{ activeMenu('section.category') }}">
                            <a href="{{ route('section.category.index') }}" class="menu-link">
                                <div
                                    data-i18n="{{ _trans('portfolio.Section') }} {{ _trans('portfolio.Category') }} {{ _trans('portfolio.List') }}">
                                    {{ _trans('portfolio.Section') }} {{ _trans('portfolio.Category') }}
                                    {{ _trans('portfolio.List') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('portfolio_read'))
                        <li class="menu-item {{ activeMenu(route('section.portfolioAndInspiration.index', 1)) }}">
                            <a href="{{ route('section.portfolioAndInspiration.index', 1) }}" class="menu-link">
                                <div data-i18n="{{ _trans('portfolio.Portfolio') }}">
                                    {{ _trans('portfolio.Portfolio') }}</div>
                            </a>
                        </li>
                    @endif
                    @if (hasPermission('inspiration_read'))
                        <li class="menu-item {{ activeMenu(route('section.portfolioAndInspiration.index', 2)) }}">
                            <a href="{{ route('section.portfolioAndInspiration.index', 2) }}" class="menu-link">
                                <div data-i18n="{{ _trans('portfolio.Inspiration') }}">
                                    {{ _trans('portfolio.Inspiration') }}</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (hasPermission('gallery_read'))
            <li class="menu-item {{ activeMenu('gallery') }}">
                <a href="{{ route('gallery.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-photo-star"></i>
                    <div data-i18n="{{ _trans('gallery.Gallery') }}">{{ _trans('gallery.Gallery') }}</div>
                </a>
            </li>
        @endif

        @if (hasPermission('event_management_read'))
            <li class="menu-item {{ openMenu(['event-management']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-calendar-event"></i>
                    <div data-i18n="{{ _trans('common.Event') }} {{ _trans('product.Management') }}">
                        {{ _trans('common.Event') }} {{ _trans('product.Management') }}</div>
                </a>
                <ul class="menu-sub">

                    @if (hasPermission('event_type_read'))
                        <li class="menu-item {{ activeMenu('event-management.type.index') }}">
                            <a href="{{ route('event-management.type.index') }}" class="menu-link">
                                <i class="menu-icon ti ti-calendar-event"></i>
                                <div data-i18n="{{ _trans('common.Event') . ' ' . _trans('common.Type') }}">
                                    {{ _trans('common.Event') . ' ' . _trans('common.Type') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('event_read'))
                        <li class="menu-item {{ activeMenu('event-management.event.index') }}">
                            <a href="{{ route('event-management.event.index') }}" class="menu-link">
                                <i class="menu-icon ti ti-calendar-event"></i>
                                <div data-i18n="{{ _trans('common.Events') }}">{{ _trans('common.Events') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('event_read'))
                        <li class="menu-item {{ activeMenu('event-management.event.calender') }}">
                            <a href="{{ route('event-management.event.calender') }}" class="menu-link">
                                <i class="menu-icon ti ti-calendar-event"></i>
                                <div data-i18n="{{ _trans('common.Calendar') }}">{{ _trans('common.Calendar') }}
                                </div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif


        @if (hasPermission('blog_read'))
            <li class="menu-item {{ openMenu(['blog']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-presentation"></i>
                    <div data-i18n="{{ _trans('blog.Blog') }}">{{ _trans('blog.Blog') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('blog_category_read'))
                        <li class="menu-item {{ activeMenu(route('blog.category.index')) }}">
                            <a href="{{ route('blog.category.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('portfolio.Category') }}">
                                    {{ _trans('portfolio.Category') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('blog_post_read'))
                        <li class="menu-item {{ activeMenu(route('blog.post.index')) }}">
                            <a href="{{ route('blog.post.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('blog.Post') }}">{{ _trans('blog.Post') }}</div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        @if (hasPermission('user_management_read'))
            <li class="menu-item {{ openMenu(['user']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-users"></i>
                    <div data-i18n="{{ _trans('user.User') }} {{ _trans('product.Management') }}">
                        {{ _trans('user.User') }} {{ _trans('product.Management') }}</div>
                </a>
                <ul class="menu-sub">

                    @if (hasPermission('customers_read'))
                        <li class="menu-item {{ activeMenu(route('user.index', Role::CUSTOMER)) }}">
                            <a href="{{ route('user.index', Role::CUSTOMER) }}" class="menu-link">
                                <div data-i18n="{{ _trans('user.Customers') }}">{{ _trans('user.Customers') }}
                                </div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('manufacturer_read'))
                        <li class="menu-item {{ activeMenu(route('user.index', Role::MANUFACTURER)) }}">
                            <a href="{{ route('user.index', Role::MANUFACTURER) }}" class="menu-link">
                                <div data-i18n="{{ _trans('product.Manufacturer') }}">
                                    {{ _trans('product.Manufacturer') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('designer_read'))
                        <li class="menu-item {{ activeMenu(route('user.index', Role::DESIGNER)) }}">
                            <a href="{{ route('user.index', Role::DESIGNER) }}" class="menu-link">
                                <div data-i18n="{{ _trans('user.Designers') }}">{{ _trans('user.Designers') }}
                                </div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('employees_read'))
                        <li class="menu-item {{ activeMenu(route('user.employeeList')) }}">
                            <a href="{{ route('user.employeeList') }}" class="menu-link">
                                <div data-i18n="{{ _trans('user.Employees') }}">{{ _trans('user.Employees') }}
                                </div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>

        @endif


        @if (hasPermission('subscribers_read'))
            <li class="menu-item {{ activeMenu(route('subscriber.index')) }}">
                <a href="{{ route('subscriber.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-share"></i>
                    <div data-i18n="{{ _trans('subscriber.Subscribers') }}">{{ _trans('subscriber.Subscribers') }}
                    </div>
                </a>
            </li>
        @endif

        @if (hasPermission('designer_contact_read'))
            <li class="menu-item {{ activeMenu(route('designer-contact.index')) }}">
                <a href="{{ route('designer-contact.index') }}" class="menu-link">
                    <i class="menu-icon ti ti-user-question"></i>
                    <div data-i18n="{{ _trans('designer.Designer') }} {{ _trans('designer.Contact') }} ">
                        {{ _trans('designer.Designer') }} {{ _trans('designer.Contact') }}</div>
                </a>
            </li>
        @endif



        @if (hasPermission('marketing_read'))
            <li class="menu-item {{ openMenu(['marketing']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-ad-2"></i>
                    <div data-i18n="{{ _trans('marketing.Marketing') }}">{{ _trans('marketing.Marketing') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('email_campaign_read'))
                        <li class="menu-item {{ activeMenu('marketing.campaign.index') }}">
                            <a href="{{ route('marketing.campaign.index') }}" class="menu-link">
                                <div
                                    data-i18n="{{ _trans('marketing.Email') }} {{ _trans('marketing.Campaign') }}">
                                    {{ _trans('marketing.Email') }} {{ _trans('marketing.Campaign') }}</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

        @endif


        <li class="menu-item {{ openMenu(['expense-management']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="{{ _trans('expense.Expense') . ' ' . _trans('expense.Management') }}">
                    {{ _trans('expense.Expense') . ' ' . _trans('expense.Management') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ activeMenu('expense-management.type.index') }}">
                    <a href="{{ route('expense-management.type.index') }}" class="menu-link">
                        <div data-i18n="{{ _trans('expense.Expense') }} {{ _trans('common.Type') }}">
                            {{ _trans('expense.Expense') }} {{ _trans('common.Type') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ activeMenu('expense-management.expenses.index') }}">
                    <a href="{{ route('expense-management.expenses.index') }}" class="menu-link">
                        <div data-i18n="{{ _trans('expense.Expenses') }}">{{ _trans('expense.Expenses') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ openMenu(['notice-board']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-bell"></i>
                <div data-i18n="{{ _trans('notice.Notice') . ' ' . _trans('notice.Board') }}">
                    {{ _trans('notice.Notice') . ' ' . _trans('notice.Board') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ activeMenu('notice-board.type.index') }}">
                    <a href="{{ route('notice-board.type.index') }}" class="menu-link">
                        <div data-i18n="{{ _trans('notice.Notice') }} {{ _trans('common.Type') }}">
                            {{ _trans('notice.Notice') }} {{ _trans('common.Type') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ activeMenu('notice-board.notice.index') }}">
                    <a href="{{ route('notice-board.notice.index') }}" class="menu-link">
                        <div data-i18n="{{ _trans('notice.Notices') }}">{{ _trans('notice.Notices') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        @if (hasPermission('contact_request_read'))
            <li class="menu-item {{ activeMenu(route('contact-request.index')) }}">
                <a href="{{ route('contact-request.index') }}" class="menu-link">
                    <i class="menu-icon ti ti-user-question"></i>
                    <div data-i18n="{{ _trans('contact.Contact') }} {{ _trans('contact.Request') }}">
                        {{ _trans('contact.Contact') }} {{ _trans('contact.Request') }}</div>
                </a>
            </li>
        @endif

        @if (hasPermission('role_read'))
            <li class="menu-item {{ activeMenu('role') }}">
                <a href="{{ route('role.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-lock"></i>
                    <div data-i18n="{{ _trans('role.Role') }}">{{ _trans('role.Role') }}</div>
                </a>
            </li>
        @endif

        @if (hasPermission('plan_subscription_read'))
            <li class="menu-item {{ openMenu(['subscription']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-calendar-dollar"></i>
                    <div data-i18n="{{ _trans('subscription.Plan') }} & {{ _trans('subscription.Subscription') }}">
                        {{ _trans('subscription.Plan') }} & {{ _trans('subscription.Subscription') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('plan_read'))
                        <li class="menu-item {{ activeMenu('subscription.plan') }}">
                            <a href="{{ route('subscription.plan.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('subscription.Plan') }}">
                                    {{ _trans('subscription.Plan') }}</div>
                            </a>
                        </li>
                    @endif
                    @if (hasPermission('subscription_read'))
                        <li class="menu-item {{ activeMenu('subscription.customer') }}">
                            <a href="{{ route('subscription.customer.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('subscription.Subscription') }}">
                                    {{ _trans('subscription.Subscription') }}</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

        @endif

        @if (hasPermission('frontend_cms_read'))
            <li class="menu-item {{ openMenu(['cms']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-adjustments-horizontal"></i>
                    <div data-i18n="{{ _trans('frontendCMS.Frontend') }} {{ _trans('frontendCMS.CMS') }}">
                        {{ _trans('frontendCMS.Frontend') }} {{ _trans('frontendCMS.CMS') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('footer_widget_read'))
                        <li class="menu-item {{ activeMenu(route('cms.footer-widget.index')) }}">
                            <a href="{{ route('cms.footer-widget.index') }}" class="menu-link">
                                <div
                                    data-i18n="{{ _trans('frontendCMS.Footer') }} {{ _trans('frontendCMS.Widget') }}">
                                    {{ _trans('frontendCMS.Footer') }} {{ _trans('frontendCMS.Widget') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('pages_read'))
                        <li class="menu-item {{ activeMenu('cms.pages') }}">
                            <a href="{{ route('cms.pages.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('frontendCMS.Pages') }}">
                                    {{ _trans('frontendCMS.Pages') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('faqs_read'))
                        <li class="menu-item {{ activeMenu(route('cms.faq.index')) }}">
                            <a href="{{ route('cms.faq.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('frontendCMS.FAQs') }}">{{ _trans('frontendCMS.FAQs') }}
                                </div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('slider_read'))
                        <li class="menu-item {{ activeMenu(route('cms.slider.index')) }}">
                            <a href="{{ route('cms.slider.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('frontendCMS.Slider') }}">
                                    {{ _trans('frontendCMS.Slider') }}</div>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif
        @if (hasPermission('system_settings_read'))
            <li class="menu-item {{ openMenu(['setting']) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="{{ _trans('system.System') }} {{ _trans('system.Settings') }}">
                        {{ _trans('system.System') }} {{ _trans('system.Settings') }}</div>
                </a>
                <ul class="menu-sub">
                    @if (hasPermission('general_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.general-setting') }}">
                            <a href="{{ route('setting.general-setting.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.General') }} {{ _trans('system.Settings') }}">
                                    {{ _trans('system.General') }} {{ _trans('system.Settings') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('file_system_read'))
                        <li class="menu-item {{ activeMenu('setting.file-system') }}">
                            <a href="{{ route('setting.file-system.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.File') }} {{ _trans('system.System') }}">
                                    {{ _trans('system.File') }} {{ _trans('system.System') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('shop_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.shop-setting') }}">
                            <a href="{{ route('setting.shop-setting.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Shop') }} {{ _trans('system.System') }}">
                                    {{ _trans('system.Shop') }} {{ _trans('system.System') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('global_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.global-setting') }}">
                            <a href="{{ route('setting.global-setting.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Global') }} {{ _trans('system.System') }}">
                                    {{ _trans('system.Global') }} {{ _trans('system.System') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('payment_method_read'))
                        <li class="menu-item {{ activeMenu('setting.payment-method') }}">
                            <a href="{{ route('setting.payment-method.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Payment') }} {{ _trans('system.Method') }}">
                                    {{ _trans('system.Payment') }} {{ _trans('system.Method') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('email_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.email-setting') }}">
                            <a href="{{ route('setting.email-setting.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('marketing.Email') }} {{ _trans('system.Settings') }}">
                                    {{ _trans('marketing.Email') }} {{ _trans('system.Settings') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('background_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.background-settings') }}">
                            <a href="{{ route('setting.background-settings.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Background') }} {{ _trans('system.Settings') }}">
                                    {{ _trans('system.Background') }} {{ _trans('system.Settings') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('color_themes_read'))
                        <li class="menu-item {{ activeMenu('setting.color-themes') }}">
                            <a href="{{ route('setting.color-themes.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Color') }} {{ _trans('system.Themes') }}">
                                    {{ _trans('system.Color') }} {{ _trans('system.Themes') }}</div>
                            </a>
                        </li>
                    @endif

                    @if (hasPermission('language_settings_read'))
                        <li class="menu-item {{ activeMenu('setting.language') }}">
                            <a href="{{ route('setting.language.index') }}" class="menu-link">
                                <div data-i18n="{{ _trans('system.Language') }} {{ _trans('system.Settings') }}">
                                    {{ _trans('system.Language') }} {{ _trans('system.Settings') }}</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif --}}


    </ul>
</aside>
<!-- / Menu -->
