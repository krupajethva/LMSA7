import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CertificatetemplatelistComponent } from './certificatetemplatelist.component';

describe('CertificatetemplatelistComponent', () => {
  let component: CertificatetemplatelistComponent;
  let fixture: ComponentFixture<CertificatetemplatelistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CertificatetemplatelistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CertificatetemplatelistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
