    package com.example.p3l.Api

    class MemberApi {
        companion object{
            val BASE_URL ="https://mygofit.my.id/api/"

            val GET_ALL_URL = BASE_URL + "indexGym/"
            val BATALGYM = BASE_URL + "batalGym/"
            val STOREDATA = BASE_URL + "addBooking"

            val GETDATAMEMBER = BASE_URL + "dataMember/"
            val GETDATABOOKINGKELAS = BASE_URL + "indexKelas/"

            val STOREBOOKKELAS = BASE_URL + "addBookKelas"
            val BATALKELAS = BASE_URL + "batalKelas/"

            val HISTORYMEMBER = BASE_URL + "indexHistoryMember/"
        }
    }