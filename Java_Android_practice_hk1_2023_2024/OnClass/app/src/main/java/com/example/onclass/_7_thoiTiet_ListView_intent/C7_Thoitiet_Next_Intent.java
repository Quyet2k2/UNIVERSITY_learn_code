package com.example.onclass._7_thoiTiet_ListView_intent;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;

public class C7_Thoitiet_Next_Intent extends AppCompatActivity {
    private ListView listDataView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c7_thoi_tiet_main_next);
        listDataView = findViewById(R.id.listThoiTietData);
        try {
            ArrayList<C7_ThoiTiet> list = getIntent().getParcelableArrayListExtra("thoiTietList");
            if (list != null) {
                C7_Adapter adapter = new C7_Adapter(this, R.layout.activity_c7_thoi_tiet_item, list);
                listDataView.setAdapter(adapter);
            }
        } catch (Exception e) {
            Toast.makeText(this, "intent " + e.getMessage().trim(), Toast.LENGTH_SHORT).show();
        }
    }
}
