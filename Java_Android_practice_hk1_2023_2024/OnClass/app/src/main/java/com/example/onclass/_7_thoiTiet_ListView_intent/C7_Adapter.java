package com.example.onclass._7_thoiTiet_ListView_intent;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.onclass.R;

import java.util.List;

//ArrayAdapter<C7_ThoiTiet>
public class C7_Adapter extends BaseAdapter {
    private final Context context;
    private final List<C7_ThoiTiet> list;
    private final int layout;

    public C7_Adapter(Context context, int layout, List<C7_ThoiTiet> list) {
//        super(context, layout, list);
        this.context = context;
        this.layout = layout;
        this.list = list;
    }

    @Override
    public int getCount() {
        return list.size();
    }

    @Override
    public Object getItem(int i) {
        return list.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        try {
            if (view == null) {
                LayoutInflater inflater = LayoutInflater.from(context);
                view = inflater.inflate(layout, null);
            }

            TextView txtName = view.findViewById(R.id.txtName);
            TextView txtDegree = view.findViewById(R.id.txtDegree);
            TextView txtWeather = view.findViewById(R.id.txtWeather);
            ImageView weatherImg = view.findViewById(R.id.weatherImg);

            if (list.get(i).getTxtDegree() < 10) {
                weatherImg.setImageResource(R.mipmap.ic_rain_launcher);
                txtWeather.setText("Cool");
            }
            if (list.get(i).getTxtDegree() < 30) {
                weatherImg.setImageResource(R.mipmap.ic_cloud_launcher);
                txtWeather.setText("Cloudy");
            }
            if (list.get(i).getTxtDegree() >= 30) {
                weatherImg.setImageResource(R.mipmap.ic_sunny_launcher);
                txtWeather.setText("Sunny");
            }

            if (txtName != null) {
                txtName.setText(list.get(i).getTxtName());
            }
            if (txtDegree != null) {
                txtDegree.setText(list.get(i).getTxtDegree() + "°C");
            }
        } catch (Exception e) {
            Toast.makeText(context, "adapter" + e.getMessage().trim(), Toast.LENGTH_SHORT).show();
        }

        return view;
    }
}
