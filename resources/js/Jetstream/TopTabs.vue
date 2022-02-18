<template>
  <TabGroup>
    <TabList>
      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[selected ? 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300' : 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300']">
          Welcome
        </button>
      </Tab>
      <Tab v-slot="{ selected }" as="template">

        <button
          :class="[selected ? 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300' : 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300']">
          Profile
        </button>

      </Tab>

      <Tab v-slot="{ selected }" as="template">
        <button
          :class="[selected ? 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-900 rounded-t-lg border-b-2 border-blue-200 hover:text-gray-600 hover:border-gray-300' : 'inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300']">
          Profile
        </button>

      </Tab>

    </TabList>
    <TabPanels class="mt-2 mb-4">
      <TabPanel>
          
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-900">Welcome tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>

      </TabPanel>
      <TabPanel>
          
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-900">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>

      </TabPanel>
      <TabPanel>
          
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">This is some placeholder content the <strong class="font-medium text-gray-900">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>

      </TabPanel>
    </TabPanels>
  </TabGroup>

</template>




<script>
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
    import { defineComponent } from 'vue'

    export default defineComponent({ 
        components: {
          TabGroup,
          TabList,
          Tab,
          TabPanels,
          TabPanel,
        },

    })

</script>