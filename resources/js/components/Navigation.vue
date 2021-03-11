<template>
        <nav class="Nav--right">
            <div class="Dropdown">
                <button aria-label="Menu">
                    <SvgIcon icon="menu"></SvgIcon>
                </button>

                <div class="Dropdown">
                    <a href="" aria-label="Account">

                        <SvgIcon icon="account"></SvgIcon>
                        <span class="Tooltip">
          Account
        </span>

                    </a>
                    <a aria-label="Dashboard">
                        <SvgIcon icon="dashboard"></SvgIcon>
                        <span class="Tooltip">
          Dashboard
                    </span>
                    </a>
                    <a :href="Laravel.routes['home']" aria-label="Item toevoegen">
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

