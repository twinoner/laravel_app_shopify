import { createApp, h } from 'vue'
import { createHttpLink, InMemoryCache, ApolloClient } from '@apollo/client/core'
import { DefaultApolloClient } from '@vue/apollo-composable'
import InstallButton from './components/InstallButton.vue'
const httpLink = createHttpLink({ uri: '/graphql' })
const apolloClient = new ApolloClient({
    link: httpLink, cache: new
        InMemoryCache()
})
const app = createApp({
    setup() {
        return {}
    },
    render() { return h(InstallButton, {}) }
})
app.provide(DefaultApolloClient, apolloClient)
app.mount('#app')