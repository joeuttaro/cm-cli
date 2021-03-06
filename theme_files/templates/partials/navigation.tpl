<nav class="navigation">

    <div class="navigation__lead-wrapper flex-grid middle">

        <div class="box small-1of2 navigation__logo-wrapper">
            <a href="#" title="{$t.Go_to_Landing_Page}" class="navigation__logo-link">
                <img src="http://placehold.it/256x256" alt="{$t.Logo_Alt}" class="navigation__logo">
            </a>
        </div>

        <div class="box small-1of2 middle navigation__search-wrapper">
            {if $languages}
                {foreach from=$languages item=language}
                    {if !$language.active}
                        <a href="{$language.url}" title="{$language.native_name}" class="navigation__language-toggle">{$language.language_code}</a>
                    {/if}
                {/foreach}
            {/if}
            <form method="get" action="/">
                <input type="text" name="s" class="navigation__search-input">
                <a href="#" title="{$t.Search}" id="search-anchor" class="navigation__search-submit"><i class="ionicons ion-ios-search"></i></a>
            </form>
        </div>

    </div>

    {if $main_menu}
        <ul class="navigation__menu-wrapper">

            {foreach from=$main_menu item=item}
                <li>
                    <a href="{$item->url}" title="{$item->title}">{$item->title}</a>

                    {if $item->children}
                        <ul>

                            {foreach from=$item->children item=child}

                                <li>
                                    <a href="{$child->url}" title="{$child->title}">{$child->title}</a>
                                </li>

                            {/foreach}

                        </ul>

                    {/if}

                </li>
            {/foreach}

        </ul>
    {/if}

</nav>
