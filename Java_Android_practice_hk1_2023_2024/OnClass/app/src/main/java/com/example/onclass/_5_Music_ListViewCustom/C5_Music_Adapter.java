package com.example.onclass._5_Music_ListViewCustom;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.TextView;

import com.example.onclass.R;

import java.util.ArrayList;

public class C5_Music_Adapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<C5_Music> list;
    private final int layout;

    public C5_Music_Adapter(Context context, int layout, ArrayList<C5_Music> list) {
        this.context = context;
        this.list = list;
        this.layout = layout;
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
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        view = inflater.inflate(layout, null);

//        Lấy ra mục bài hát tương ứng với vị trí i
//        C5_Music music = (C5_Music) getItem(i);

        TextView txtName = view.findViewById(R.id.txtName);
        txtName.setText(list.get(i).getTxtName());
        TextView txtAuthor = view.findViewById(R.id.txtAuthor);
        txtAuthor.setText(list.get(i).getTxtAuthor());
        CheckBox checkboxMusic = view.findViewById(R.id.checkboxMusic);

//        Đặt trạng thái của checkbox dựa trên thuộc tính selected của mục bài hát
        if (list.get(i) != null) {
            checkboxMusic.setChecked(list.get(i).getCheck());
//            Xử lý sự kiện khi người dùng tương tác với checkbox
            checkboxMusic.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
//                    Cập nhật tráng thái selected
                    list.get(i).setCheck(b);
                }
            });
        }
        return view;
    }
}
