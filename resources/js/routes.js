let login = require('./components/auth/login.vue').default
let register = require('./components/auth/register.vue').default
let forgot = require('./components/auth/forgot.vue').default
let logout = require('./components/auth/logout.vue').default
let Home = require('./components/Home.vue').default
    //employee
let AddEmployee = require('./components/employee/create.vue').default
let EditEmployee = require('./components/employee/edit.vue').default
let AllEmployee = require('./components/employee/index.vue').default
    //supplier
let AllSupplier = require('./components/supplier/index.vue').default
let AddSupplier = require('./components/supplier/create.vue').default
let EditSupplier = require('./components/supplier/edit.vue').default
    //category
let AllCategory = require('./components/Category/index.vue').default
let AddCategory = require('./components/Category/create.vue').default
let EditCategory = require('./components/Category/edit.vue').default
    //product
let AllProduct = require('./components/product/index.vue').default
let AddProduct = require('./components/product/create.vue').default
let EditProduct = require('./components/product/edit.vue').default
    //Expense
let AllExpense = require('./components/expense/index.vue').default
let AddExpense = require('./components/expense/create.vue').default
let EditExpense = require('./components/expense/edit.vue').default
    //salary
let PaySalary = require('./components/salary/create.vue').default
let AllSalary = require('./components/salary/index.vue').default
let AllPaySalary = require('./components/salary/paysalries.vue').default
let EditSalary = require('./components/salary/edit.vue').default
    //Stock
let Stock = require('./components/product/stock.vue').default
let EditStock = require('./components/product/editstock.vue').default
    //Customer
let AllCustomer = require('./components/customer/index.vue').default
let AddCustomer = require('./components/customer/create.vue').default
let EditCustomer = require('./components/customer/edit.vue').default
    //POS
let POS = require('./components/pos/pos.vue').default
    //orders
let Orders = require('./components/order/orders.vue').default

///User Side
let userindex = require('./components/UserSide/index.vue').default
export const routes = [
    ///user side routes
    { path: '/', name: '/', component: userindex },
    //end of user side routes
    { path: '/login', name: '/login', component: login },
    { path: '/register', name: 'register', component: register },
    { path: '/forgot', name: 'forgot', component: forgot },
    { path: '/Home', name: 'Home', component: Home },
    { path: '/logout', name: 'logout', component: logout },
    //employee
    { path: '/Add-Employee', name: 'Add-Employee', component: AddEmployee },
    { path: '/All-Employee', name: 'All-Employee', component: AllEmployee },
    { path: '/Edit-Employee/:employee_id', name: 'Edit-Employee', component: EditEmployee },
    //supplier
    { path: '/All-Supplier', name: 'All-Supplier', component: AllSupplier },
    { path: '/Add-Supplier', name: 'Add-Supplier', component: AddSupplier },
    { path: '/Edit-Supplier/:supplier_id', name: 'Edit-Supplier', component: EditSupplier },
    //category
    { path: '/All-Category', name: 'All-Category', component: AllCategory },
    { path: '/Add-Category', name: 'Add-Category', component: AddCategory },
    { path: '/Edit-Category/:category_id', name: 'Edit-Category', component: EditCategory },
    //product
    { path: '/All-Product', name: 'All-Product', component: AllProduct },
    { path: '/Add-Product', name: 'Add-Product', component: AddProduct },
    { path: '/Edit-Product/:product_id', name: 'Edit-Product', component: EditProduct },
    //Expense
    { path: '/All-Expense', name: 'All-Expense', component: AllExpense },
    { path: '/Add-Expense', name: 'Add-Expense', component: AddExpense },
    { path: '/Edit-Expense/:expense_id', name: 'Edit-Expense', component: EditExpense },
    //Salary
    { path: '/Pay-Salary/:employee_id', name: 'Pay-Salary', component: PaySalary },
    { path: '/All-Salary', name: 'All-Salary', component: AllSalary },
    { path: '/AllPay-Salary/:salary_month', name: 'AllPay-Salary', component: AllPaySalary },
    { path: '/Edit-Salary/:salary_id/:employee_id', name: 'Edit-Salary', component: EditSalary },
    //Stock
    { path: '/Stock', name: 'Stock', component: Stock },
    { path: '/Edit-Stock/:product_id', name: 'Edit-Stock', component: EditStock },
    //Customer
    { path: '/All-Customer', name: 'All-Customer', component: AllCustomer },
    { path: '/Add-Customer', name: 'Add-Customer', component: AddCustomer },
    { path: '/Edit-Customer/:customer_id', name: 'Edit-Customer', component: EditCustomer },
    //POS
    { path: '/Point-of-Sale', name: 'Point-of-Sale', component: POS },
    //orders
    { path: '/Orders', name: 'Orders', component: Orders },


]