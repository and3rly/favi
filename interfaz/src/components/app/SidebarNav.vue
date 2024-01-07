<script setup lang="ts">
import SidebarNav from '@/components/app/SidebarNav.vue';
import { useRouter, RouterLink } from 'vue-router'
import { onMounted, ref  } from 'vue';

defineProps<{
  menu: {
  	icon: String,
  	text: String,
  	url: String,
  	highlight: Boolean,
  	children: Object
  };
}>();

function subIsActive(urls) {
	var match = false;

	if(urls>0){
		match = true;
	}
	
	return match;
}

const isExpanded = ref(false);

function toggleSubMenu() {
  isExpanded.value = !isExpanded.value;
}

function handleMenuClick() {
  // Perform any additional actions when the menu item is clicked
  // You can add logic based on your requirements
}
</script>
<template>
	<!-- menu with submenu -->
	<div v-if="menu.countChilds>0" class="menu-item has-sub" v-bind:class="{ 'active': subIsActive(menu.countChilds) }">
		<!-- <router-link @click="toggleSubMenu"> -->
			<div class="menu-item">
				<a class="menu-link" @click="toggleSubMenu">
					<span class="menu-icon" v-if="menu.icon">
						<i v-bind:class="menu.icon"></i>
						<span class="w-5px h-5px rounded-3 bg-theme position-absolute top-0 end-0 mt-3px me-3px" v-if="menu.highlight"></span>
					</span>
					<span class="menu-text">{{ menu.text }}</span>
					<span class="menu-caret" v-if="menu.childs"><b class="caret"></b></span>
				</a>
			</div>
		<!-- </router-link> -->
		<div class="menu-submenu" v-show="isExpanded">
			<router-link v-if="menu.url" v-bind:to="menu.url" custom v-slot="{ navigate, href, isActive }">
				<div class="menu-item" v-bind:class="{ 'active': isActive }">
					<a v-bind:href="href" @click="navigate" class="menu-link">
						<span class="menu-icon" v-if="menu.icon">
							<i v-bind:class="menu.icon"></i>
							<span class="w-5px h-5px rounded-3 bg-theme position-absolute top-0 end-0 mt-3px me-3px" v-if="menu.highlight"></span>
						</span>
						<span class="menu-text">{{ menu.text }}</span>
					</a>
				</div>
			</router-link>
			<template v-for="(submenu, index) in menu.childs">
				<sidebar-nav v-bind:menu="submenu"></sidebar-nav>
			</template>
		</div>
	</div>
  
	<!-- menu without submenu -->
	<router-link v-else v-bind:to="menu.url" custom v-slot="{ navigate, href, isActive }">
		<div class="menu-item" v-bind:class="{ 'active': isActive }">
			<a v-bind:href="href" @click="navigate" class="menu-link">
				<span class="menu-icon" v-if="menu.icon">
					<i v-bind:class="menu.icon"></i>
					<span class="menu-icon-label" v-if="menu.label">{{ menu.label }}</span>
				</span>
				<span class="menu-text">{{ menu.text }}</span>
			</a>
		</div>
	</router-link>
</template>