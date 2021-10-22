import Vuex from 'vuex'
import Vue from 'vue'
import axios from 'axios'
Vue.use(Vuex)
let cart = window.localStorage.getItem('cart');
export default new Vuex.Store({
    state: { //state is data

        products: [],
        cart: cart ? JSON.parse(cart) : [],

    },
    getters: { //like computed properties
        getproduct(state) {
            return state.products
        },
        getcartproducts(state) {
            return state.cart
        },
        sumofqty(state) {
            let sum = 0;
            state.cart.filter(cart => {
                sum = sum + cart.qty
            })
            return sum
        },
        sumofsubtotal(state) {
            let subtotal = 0;
            state.cart.filter(cart => {
                subtotal = subtotal + cart.subtotal
            })
            return subtotal
        }

    },
    actions: {
        ///api call
        async fetchproducts({ commit }) {

            const response = await axios.get('/api/product');
            commit('setproducts', response.data);
        },
        async addtocart(context, product) {
            const cartItem = context.state.cart.find(item => item.id === product.id)
            if (!cartItem) {
                context.commit('addtocart', product);
            } else {
                context.commit('addqtycart', cartItem);

            }

        },
        async removedItem(context, productID) {

            /// const cartItem = context.state.cart.find(item => item.id !== productID)
            const cartItem = context.state.cart.filter(cart => {
                return cart.id != productID
            });
            context.commit('removetocart', cartItem)

        },
        async increment_cart(context, product) {
            const cartItem = context.state.cart.find(item => item.id === product.id)
            if (!cartItem) {
                context.commit('addtocart', product);
            } else {
                context.commit('addqtycart', cartItem);

            }

        },
        async decrement_cart(context, product) {


            context.commit('removeqtycart', product);

        }



    },
    mutations: {
        ///something new or update state
        setproducts(state, products) {
            state.products = products
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
        },
        addtocart(state, product) {
            state.cart.push({ id: product.id, qty: 1, price: product.selling_price, title: product.product_name, subtotal: product.selling_price })
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
        },
        addqtycart(state, product) {
            product.qty++
                product.subtotal = product.price * product.qty
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
        },
        removeqtycart(state, product) {

            product.qty = product.qty - 1
            product.subtotal = product.price * product.qty
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
        },
        removetocart(state, products) {
            state.cart = products
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
        }


    }
})