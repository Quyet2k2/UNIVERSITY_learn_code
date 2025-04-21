package com.example.onclass._3_Weather_ListViewCustom;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;
import com.example.onclass.databinding.Activity3ThoitietBinding;

import java.util.ArrayList;

public class C3_Weather_MainListViewCustom extends AppCompatActivity {
    // private static final int SELECT_IMAGE = 1;
    private final String sunny = "Nhiều nắng", rain = "Mưa nhiều", clouds = "Nhiều mây";
    private final int sunny_t = R.mipmap.ic_sunny_launcher, rain_t = R.mipmap.ic_rain_launcher, clouds_t = R.mipmap.ic_cloud_launcher;
    private Activity3ThoitietBinding activity3ThoitietBinding;
    private ArrayList<C3_Weather> a3WeatherArrayList;
    private C3_Weather c3Weather;
    private C3_Weather_Adapter weatherAdapter;

    //private Uri selectedImageUri;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        activity3ThoitietBinding = Activity3ThoitietBinding.inflate(getLayoutInflater());
        setContentView(activity3ThoitietBinding.getRoot());

        a3WeatherArrayList = new ArrayList<>();
        weatherAdapter = new C3_Weather_Adapter(this, a3WeatherArrayList);
        activity3ThoitietBinding.listWeather.setAdapter(weatherAdapter);

        activity3ThoitietBinding.btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                a3WeatherArrayList.add(
                        addListWeather(activity3ThoitietBinding.edtAddress.getText().toString(),
                                Integer.valueOf(activity3ThoitietBinding.edtC.getText().toString()))
                );
            }
        });
        activity3ThoitietBinding.btnView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                weatherAdapter.notifyDataSetChanged();
            }
        });

        activity3ThoitietBinding.listWeather.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
            @Override
            public boolean onItemLongClick(AdapterView<?> adapterView, View view, int i, long l) {
                int positive = i;
                AlertDialog.Builder alter = new AlertDialog.Builder(C3_Weather_MainListViewCustom.this);
                alter.setTitle("Ban co chac muon xoa khong ?");
                alter.setPositiveButton("0K", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        a3WeatherArrayList.remove(positive);
                        weatherAdapter.notifyDataSetChanged();
                        dialogInterface.dismiss();
                    }
                });
                AlertDialog dialog = alter.create();
                dialog.show();
                return false;
            }
        });

        activity3ThoitietBinding.listWeather.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                activity3ThoitietBinding.edtAddress.setText(a3WeatherArrayList.get(i).getAddress());
                activity3ThoitietBinding.edtC.setText(String.valueOf(a3WeatherArrayList.get(i).getC()));

                activity3ThoitietBinding.btnUpdate.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        a3WeatherArrayList.set(i,
                                addListWeather(activity3ThoitietBinding.edtAddress.getText().toString(),
                                        Integer.valueOf(activity3ThoitietBinding.edtC.getText().toString()))
                        );
                        weatherAdapter.notifyDataSetChanged();
                    }
                });
            }
        });

    }

    private C3_Weather addListWeather(String address, int c) {
        c3Weather = new C3_Weather();
        c3Weather.setAddress(address);
        c3Weather.setC(c);
        if (c3Weather.getC() <= 20) {
            c3Weather.setWeather(rain);
            c3Weather.setImage(rain_t);
        } else if (20 < c3Weather.getC() && c3Weather.getC() <= 30) {
            c3Weather.setWeather(clouds);
            c3Weather.setImage(clouds_t);
        } else {
            c3Weather.setWeather(sunny);
            c3Weather.setImage(sunny_t);
        }
        return c3Weather;
    }


}
