package com.example.p3l.Activity

import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import androidx.core.content.res.ResourcesCompat
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout
import com.android.volley.AuthFailureError
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.p3l.Adapter.IzinInstrukturAdapter
import com.example.p3l.Api.IzinInstrukturApi
import com.example.p3l.Model.IzinInstruktur
import com.example.p3l.R
import com.example.p3l.databinding.ActivityIzinInstrukturBinding
import org.json.JSONObject
import www.sanju.motiontoast.MotionToast
import www.sanju.motiontoast.MotionToastStyle
import java.nio.charset.StandardCharsets

class IzinInstrukturActivity : AppCompatActivity() {
    private lateinit var sharedPreferences: SharedPreferences
    private lateinit var binding: ActivityIzinInstrukturBinding
    private var queue: RequestQueue? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityIzinInstrukturBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        supportActionBar?.hide()
        sharedPreferences = getSharedPreferences("login", Context.MODE_PRIVATE)

        val id = sharedPreferences.getInt("id",-1)
        queue = Volley.newRequestQueue(this)

        binding.srIzinInstruktur.setOnRefreshListener(SwipeRefreshLayout.OnRefreshListener{allData(id)})
        allData(id)

        binding.btnAdd.setOnClickListener {
            val intent = Intent(this@IzinInstrukturActivity, AddIzinInstrukturActivity::class.java)
            startActivity(intent)
        }
    }

    private fun allData(id: Int) {
        binding.srIzinInstruktur.isRefreshing = true
        val stringRequest: StringRequest = object :
            StringRequest(Method.GET, IzinInstrukturApi.GET_IZN_URL + id, Response.Listener { response ->
                var jo = JSONObject(response.toString())
                var permission = arrayListOf<IzinInstruktur>()
                var id : Int = jo.getJSONArray("data").length()

                for(i in 0 until id) {
                    var data = IzinInstruktur(
                        jo.getJSONArray("data").getJSONObject(i).getInt("ID_INSTRUKTUR"),
                        jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_IZIN_INSTRUKTUR"),
                        jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_KONFIRMASI"),
                        jo.getJSONArray("data").getJSONObject(i).getString("TANGGAL_MELAKUKAN_IZIN"),
                        jo.getJSONArray("data").getJSONObject(i).getString("STATUS_IZIN"),
                        jo.getJSONArray("data").getJSONObject(i).getString("KETERANGAN_IZIN"),
                        jo.getJSONArray("data").getJSONObject(i).getString("NAMA_INSTRUKTUR_PENGGANTI"),
                    )
                    permission.add(data)
                }
                var data_array: Array<IzinInstruktur> = permission.toTypedArray()

                val layoutManager = LinearLayoutManager(this)
                val adapter : IzinInstrukturAdapter = IzinInstrukturAdapter(permission,this)
                val rvPermission : RecyclerView = findViewById(R.id.rv_izinInstruktur)

                rvPermission.layoutManager = layoutManager
                rvPermission.setHasFixedSize(true)
                rvPermission.adapter = adapter

                binding.srIzinInstruktur.isRefreshing = false

                if (!data_array.isEmpty()) {
//                    Toast.makeText(this@JanjiTemuActivity, "Data Berhasil Diambil!", Toast.LENGTH_SHORT).show()
                    MotionToast.darkToast(
                        this, "Notification Display!",
                        "Succesfully get data",
                        MotionToastStyle.SUCCESS,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(
                            this,
                            www.sanju.motiontoast.R.font.helvetica_regular
                        )
                    )
                }else {
                    MotionToast.darkToast(
                        this, "Notification Display!",
                        "Data not found",
                        MotionToastStyle.SUCCESS,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(
                            this,
                            www.sanju.motiontoast.R.font.helvetica_regular
                        )
                    )
                }

            }, Response.ErrorListener { error ->
                binding.srIzinInstruktur.isRefreshing = true
                try {
                    val responseBody = String(error.networkResponse.data, StandardCharsets.UTF_8)
                    val errors = JSONObject(responseBody)
//                    Toast.makeText(this@JanjiTemuActivity, errors.getString("message"), Toast.LENGTH_SHORT).show()
                    MotionToast.darkToast(
                        this,"Notification Display!",
                        errors.getString("message"),
                        MotionToastStyle.INFO,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
                } catch (e: Exception){
//                    Toast.makeText(this@JanjiTemuActivity, e.message, Toast.LENGTH_SHORT).show()
                    MotionToast.darkToast(
                        this,"Notification Display!",
                        e.message.toString(),
                        MotionToastStyle.INFO,
                        MotionToast.GRAVITY_BOTTOM,
                        MotionToast.LONG_DURATION,
                        ResourcesCompat.getFont(this, www.sanju.motiontoast.R.font.helvetica_regular))
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
}