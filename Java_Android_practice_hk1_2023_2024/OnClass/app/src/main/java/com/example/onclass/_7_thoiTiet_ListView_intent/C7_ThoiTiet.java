package com.example.onclass._7_thoiTiet_ListView_intent;

import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

public class C7_ThoiTiet implements Parcelable {

    public static final Creator<C7_ThoiTiet> CREATOR = new Creator<C7_ThoiTiet>() {
        @Override
        public C7_ThoiTiet createFromParcel(Parcel in) {
            return new C7_ThoiTiet(in);
        }

        @Override
        public C7_ThoiTiet[] newArray(int size) {
            return new C7_ThoiTiet[size];
        }
    };
    private String txtName;
    private int txtDegree;

    public C7_ThoiTiet(String txtName, int txtDegree) {
        this.txtName = txtName;
        this.txtDegree = txtDegree;
    }

    protected C7_ThoiTiet(Parcel in) {
        txtName = in.readString();
        txtDegree = in.readInt();
    }

    public String getTxtName() {
        return txtName;
    }

    public void setTxtName(String txtName) {
        this.txtName = txtName;
    }

    public int getTxtDegree() {
        return txtDegree;
    }

    public void setTxtDegree(int txtDegree) {
        this.txtDegree = txtDegree;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel parcel, int i) {
        parcel.writeString(txtName);
        parcel.writeInt(txtDegree);
    }
}
