package com.example.p3l.Activity

import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Toast
import androidx.core.content.res.ResourcesCompat
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Adapter.PresensiAdapter
import com.example.p3l.Api.PresensiInstrukturApi
import com.example.p3l.Model.PresensiInstruktur
import com.example.p3l.Model.PresensiInstrukturs
import com.example.p3l.R
import com.example.p3l.databinding.ActivityPresensiInstrukturBinding
import com.google.gson.Gson
import org.json.JSONObject
import www.sanju.motiontoast.MotionToast
import www.sanju.motiontoast.MotionToastStyle
import java.nio.charset.StandardCharsets

class PresensiInstrukturActivity : AppCompatActivity() {
    private lateinit var sharedPreferences: SharedPreferences
    private lateinit var binding: ActivityPresensiInstrukturBinding
    private var queue: RequestQueue? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityPresensiInstrukturBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        supportActionBar?.hide()
        sharedPreferences = getSharedPreferences("login", Context.MODE_PRIVATE)

        val id = sharedPreferences.getInt("id",0)
        queue = Volley.newRequestQueue(this)

        binding.srPresensi.setOnRefreshListener(SwipeRefreshLayout.OnRefreshListener{allData()})
        allData()
    }

    private fun allData() {
        binding.srPresensi.isRefreshing = true
        val stringRequest: StringRequest = object :
            StringRequest(Method.GET, PresensiInstrukturApi.GET_ALL_URL, Response.Listener { response ->
                var jo = JSONObject(response.toString())
                var schedule = arrayListOf<PresensiInstruktur>()
                var id : Int = jo.getJSONArray("data").length()

                for(i in 0 until id) {
                    var data = PresensiInstruktur(
                        jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_JADWAL_HARIAN"),
                        jo.getJSONArray("data").getJSONObject(i).getString("NAMA_INSTRUKTUR"),
                        jo.getJSONArray("data").getJSONObject(i).getString("NAMA_KELAS"),
                        jo.getJSONArray("data").getJSONObject(i).getString("KETERANGAN"),
                        jo.getJSONArray("data").getJSONObject(i).getString("HARI_JADWAL"),
                        jo.getJSONArray("data").getJSONObject(i).getInt("ID_INSTRUKTUR"),
                        jo.getJSONArray("data").getJSONObject(i).getDouble("TARIF"),
                        jo.getJSONArray("data").getJSONObject(i).getString("JAM_MULAI"),
                        jo.getJSONArray("data").getJSONObject(i).getString("JAM_SELESAI"),
//                        jo.getJSONArray("data").getJSONObject(i).getString("JAM_MULAI"),
//                        jo.getJSONArray("data").getJSONObject(i).getString("JAM_SELESAI"),

                    )
                    schedule.add(data)
                }
                var data_array: Array<PresensiInstruktur> = schedule.toTypedArray()

                val layoutManager = LinearLayoutManager(this)
                val adapter : PresensiAdapter = PresensiAdapter(schedule,this)
                val rvPermission : RecyclerView = findViewById(R.id.rv_presensi)

                rvPermission.layoutManager = layoutManager
                rvPermission.setHasFixedSize(true)
                rvPermission.adapter = adapter

                binding.srPresensi.isRefreshing = false

                if (!data_array.isEmpty()) {
                   Toast.makeText(this@PresensiInstrukturActivity, "Data Berhasil Diambil!", Toast.LENGTH_SHORT).show()

                }else {
                    Toast.makeText(this@PresensiInstrukturActivity, "Data Tidak Berhasil Diambil!", Toast.LENGTH_SHORT).show()
                }

            }, Response.ErrorListener { error ->
                binding.srPresensi.isRefreshing = true
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)
                    Toast.makeText(this@PresensiInstrukturActivity, errors.getString("message"), Toast.LENGTH_SHORT).show()

                } catch (e: Exception){
                    Toast.makeText(this@PresensiInstrukturActivity, e.message, Toast.LENGTH_SHORT).show()
                }
            }){
            @Throws(AuthFailureError::class)
            override fun getHeaders(): Map<String, String> {
                val headers = HashMap<String, String>()
                headers["Accept"] = "application/json"
                headers["Authorization"] = "Bearer " + sharedPreferences.getString("token",null);
                return headers
            }
        }
        queue!!.add(stringRequest)
    }


//    fun store(id_instruktur: Int, tanggal: String) {
//        val presence = PresensiInstrukturs(id_instruktur, tanggal)
//
//        val stringRequest: StringRequest = object : StringRequest(
//            Request.Method.POST,
//            PresensiInstrukturApi.STOREDATA,
//            Response.Listener { response ->
//                val gson = Gson()
//                var presence_data = gson.fromJson(response, PresensiInstrukturs::class.java)
//
//                var resJO = JSONObject(response.toString())
//                val userobj = resJO.getJSONObject("data")
//
//                if (presence_data != null) {
//                    MotionToast.darkToast(
//                        this, "Notification Display!",
//                        "Succesfully get data",
//                        MotionToastStyle.SUCCESS,
//                        MotionToast.GRAVITY_BOTTOM,
//                        MotionToast.LONG_DURATION,
//                        ResourcesCompat.getFont(
//                            this,
//                            www.sanju.motiontoast.R.font.helvetica_regular
//                        )
//                    )
//                    val intent = Intent(this@PresensiInstrukturActivity, PresensiInstrukturActivity::class.java)
//                    startActivity(intent)
//                } else {
//
//                }
//                return@Listener
//            },
//            Response.ErrorListener { error ->
//                try {
//                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
//                    val errors = JSONObject(responseBody)
//                } catch (e: java.lang.Exception) {
//                    Toast.makeText(
//                        this@PresensiInstrukturActivity,
//                        e.message,
//                        Toast.LENGTH_LONG
//                    ).show()
//                }
//            }) {
//
//            @Throws(AuthFailureError::class)
//            override fun getHeaders(): Map<String, String> {
//                val headers = HashMap<String, String>()
//                headers["Accept"] = "application/json"
//                headers["Authorization"] = "Bearer " + sharedPreferences.getString("token", null)
//                return headers
//            }
//
//            @Throws(AuthFailureError::class)
//            override fun getBody(): ByteArray {
//                val gson = Gson()
//                val requestBody = gson.toJson(presence)
//                return requestBody.toByteArray(StandardCharsets.UTF_8)
//            }
//
//            override fun getBodyContentType(): String {
//                return "application/json; charset=utf-8;"
//            }
//        }
//
//        queue!!.add(stringRequest)
//    }

    fun store(id_instruktur: Int, tanggal: String){
        val presence = PresensiInstrukturs(
            id_instruktur,
            tanggal
        )

        val stringRequest: StringRequest =
            object : StringRequest(Request.Method.POST, PresensiInstrukturApi.STOREDATA, Response.Listener { response ->
                val gson = Gson()
                var presence_data = gson.fromJson(response, PresensiInstrukturs::class.java)

                var resJO = JSONObject(response.toString())
                val userobj = resJO.getJSONObject("data")

                if(presence_data!= null) {

                    val intent = Intent(this@PresensiInstrukturActivity, PresensiInstrukturActivity::class.java)
                    startActivity(intent)
                }
                else {

                }
                return@Listener
            }, Response.ErrorListener { error ->
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)

                }catch (e: java.lang.Exception) {
                    Toast.makeText(this@PresensiInstrukturActivity, e.message,
                        Toast.LENGTH_LONG).show();
                }
            }) {
                @kotlin.jvm.Throws(AuthFailureError::class)
                override fun getHeaders(): Map<String, String> {
                    val headers = HashMap<String, String>()
                    headers["Accept"] = "application/json"
                    headers["Authorization"] = "Bearer " + sharedPreferences.getString("token",null);
                    return headers
                }

                @kotlin.jvm.Throws(AuthFailureError::class)
                override fun getBody(): ByteArray {
                    val gson = Gson()
                    val requestBody = gson.toJson(presence)
                    return requestBody.toByteArray(StandardCharsets.UTF_8)
                }

                override fun getBodyContentType(): String {
                    return "application/json; charset=utf-8;"
                }
            }
        queue!!.add(stringRequest)
    }

}