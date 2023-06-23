package com.example.p3l.Activity

import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.ArrayAdapter
import android.widget.Toast
import androidx.core.content.res.ResourcesCompat
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Api.IzinInstrukturApi
import com.example.p3l.Model.IzinInstruktur
import com.example.p3l.R
import com.example.p3l.databinding.ActivityAddIzinInstrukturBinding
import com.google.gson.Gson
import org.json.JSONObject
import www.sanju.motiontoast.MotionToast
import www.sanju.motiontoast.MotionToastStyle
import java.nio.charset.StandardCharsets

class AddIzinInstrukturActivity : AppCompatActivity() {
    private lateinit var sharedPreferences: SharedPreferences
    private var queue: RequestQueue? = null
    private lateinit var binding: ActivityAddIzinInstrukturBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityAddIzinInstrukturBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        supportActionBar?.hide()

        sharedPreferences = getSharedPreferences("login", Context.MODE_PRIVATE)
        val id = sharedPreferences.getInt("id",-1)

        queue = Volley.newRequestQueue(this)

        setDropdownSchedule(id)

        binding.btnCancel.setOnClickListener {
            val intent = Intent(this@AddIzinInstrukturActivity, IzinInstrukturActivity::class.java)
            startActivity(intent)
        }

        binding.btnStore.setOnClickListener {
            storePermission(id)
        }

    }

    fun setDropdownSchedule(id: Int) {
        val stringRequest: StringRequest = object :
            StringRequest(Method.GET, IzinInstrukturApi.GET_JADWAL_URL + id, Response.Listener { response ->
                var jo = JSONObject(response.toString())
                var schedule = arrayListOf<String>()
                var id : Int = jo.getJSONArray("data").length()

                for(i in 0 until id) {
//                    var data = DropDownSchedule(
//                        jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_JADWAL_HARIAN"),
//                    )
                    schedule.add(jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_JADWAL_HARIAN"))
                }
//                var data_array: Array<DropDownSchedule> = schedule.toTypedArray()

                val adapter: ArrayAdapter<String> = ArrayAdapter(this,
                    R.layout.item_list_dropdown,R.id.dataList, schedule)
                binding.edTglIzin.setAdapter(adapter)

                if (!schedule.isEmpty()) {
//                    Toast.makeText(this@JanjiTemuActivity, "Data Berhasil Diambil!", Toast.LENGTH_SHORT).show()
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
                }else {
//                    MotionToast.darkToast(
//                        this, "Notification Display!",
//                        "Failed get data",
//                        MotionToastStyle.SUCCESS,
//                        MotionToast.GRAVITY_BOTTOM,
//                        MotionToast.LONG_DURATION,
//                        ResourcesCompat.getFont(
//                            this,
//                            www.sanju.motiontoast.R.font.helvetica_regular
//                        )
//                    )
                }

            }, Response.ErrorListener { error ->
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)
//                    Toast.makeText(this@JanjiTemuActivity, errors.getString("message"), Toast.LENGTH_SHORT).show()
//                    MotionToast.darkToast(
//                        this,"Notification Display!",
//                        errors.getString("message"),
//                        MotionToastStyle.INFO,
//                        MotionToast.GRAVITY_BOTTOM,
//                        MotionToast.LONG_DURATION,
//                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
                } catch (e: Exception){
//                    Toast.makeText(this@JanjiTemuActivity, e.message, Toast.LENGTH_SHORT).show()
//                    MotionToast.darkToast(
//                        this,"Notification Display!",
//                        e.message.toString(),
//                        MotionToastStyle.INFO,
//                        MotionToast.GRAVITY_BOTTOM,
//                        MotionToast.LONG_DURATION,
//                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
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

    private fun storePermission(id: Int){
        val permisson = IzinInstruktur(
            id,
            binding.edTglIzin.text.toString(),
            null,
            null,
            null,
            binding.inputLayoutKeterangan.getEditText()?.getText().toString(),
            binding.inputLayoutinstrukturpengganti.getEditText()?.getText().toString(),
        )

        val stringRequest: StringRequest =
            object : StringRequest(Request.Method.POST, IzinInstrukturApi.STOREIZIN, Response.Listener { response ->
                val gson = Gson()

                var permission = gson.fromJson(response, IzinInstruktur::class.java)
                var resJO = JSONObject(response.toString())
//                val userobj = resJO.getJSONObject("data")

                if(permission != null) {
                    MotionToast.darkColorToast(this,"Notification Success!",
                        "Succesfully Create Permission!",
                        MotionToastStyle.SUCCESS,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
                    val intent = Intent(this@AddIzinInstrukturActivity, IzinInstrukturActivity::class.java)
//                    sharedPreferences.edit()
//                        .putInt("id",userobj.getInt("ID_PEGAWAI"))
//                        .putString("role","MO")
//                        .putString("token",token)
//                        .apply()
                    startActivity(intent)
                }
                else {
                    MotionToast.darkColorToast(this,"Notification Failed!",
                        "Failed Create Permission",
                        MotionToastStyle.ERROR,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
                }
                return@Listener
            }, Response.ErrorListener { error ->
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)
                    MotionToast.darkColorToast(this,"Notification Error!",
                        errors.getString("message"),
                        MotionToastStyle.ERROR,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
                }catch (e: java.lang.Exception) {
                    Toast.makeText(this@AddIzinInstrukturActivity, e.message,
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
                    val requestBody = gson.toJson(permisson)
                    return requestBody.toByteArray(StandardCharsets.UTF_8)
                }

                override fun getBodyContentType(): String {
                    return "application/json; charset=utf-8;"
                }
            }
        queue!!.add(stringRequest)
    }

}