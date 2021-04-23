<template>
        <nav class="Nav--right">
            <div class="Dropdown">
                <button id="NavButton" aria-label="Menu">
                    <SvgIcon icon="menu"></SvgIcon>
                </button>

                <div class="Dropdown">
                    <a href="Laravel.routes['users']" aria-label="Account">
                        <SvgIcon icon="account"></SvgIcon>
                        <span class="Tooltip">
                     Account
                    </span>

                    </a>
                    <a :href="Laravel.routes['dashboard']" aria-label="Dashboard">
                        <SvgIcon icon="dashboard"></SvgIcon>
                        <span class="Tooltip">
                        Dashboard
                    </span>
                    </a>
                    <a :href="Laravel.routes['edit.item.location']" aria-label="Dashboard">
                        <SvgIcon icon="edit"></SvgIcon>
                        <span class="Tooltip">
                        Locatie aanpassen
                    </span>
                    </a>
                    <a :href="Laravel.routes['create.item']" aria-label="Item toevoegen">
                        <SvgIcon icon="plus"></SvgIcon>
                        <span class="Tooltip">
                            Item toevoegen
                        </span>
                    </a>
                </div>
            </div>
        </nav>
</template>

<script>
import SvgIcon from "./SvgIcon";
export default {
    name: 'Navigation',
    components: {
        SvgIcon
    },
    data:()=>{
        return {
            Laravel: window.Laravel
        }
    }
}
</script>

