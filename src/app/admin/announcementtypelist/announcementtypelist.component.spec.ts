import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AnnouncementtypelistComponent } from './announcementtypelist.component';

describe('AnnouncementtypelistComponent', () => {
  let component: AnnouncementtypelistComponent;
  let fixture: ComponentFixture<AnnouncementtypelistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AnnouncementtypelistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AnnouncementtypelistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
