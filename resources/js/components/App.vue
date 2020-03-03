<template>

        
<div class="h-screen pb-14 bg-right bg-cover">
	<!--Main-->
	<div class="container pt-24 md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">
		
        <div class="w-full  flex-row justify-center items-center">
            <h1 class=" my-4 text-3xl md:text-5xl text-purple-800 font-bold leading-tight text-center md:text-left slide-in-bottom-h1">SEO</h1>
		    <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-subtitle">Zkontrolujte vaši stránku!</p>
            <div class="w-full flex-1 justify-center md:flex-none   overflow-y-hidden">
                <router-view />
            </div>		
        </div>
		<!--Footer-->
		<div class="w-full pt-16 pb-6 text-sm text-center md:text-left fade-in">
			<a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; SEO 2020</a>
		</div>
		
	</div>
	

</div>
</template>

<script>
export default {};
</script>
