package com.example.p3l.Api



class PegawaiApi {
    companion object{
        val BASE_URL ="https://mygofit.my.id/api/"

        val LOGIN_URL = BASE_URL + "login"
        val RESET_PASSWORD_URL = BASE_URL + "resetpw"
        val LOGOUT_URL = BASE_URL + "logout"

        val GETALLDATA_URL = BASE_URL + "indexApi"
    }
}